// * CodeGuppyTools *

const assetsPrefix = "https://prog.vikweb.hu/assets"
const currentPrefix = assetsPrefix + "/4.hunt"

function sprite(img, x, y, scale) {
    let result = new Sprite(img, x, y)
    result.scale = scale * 2
    result.collider = 'static'
    return result
}

function println(text) {
    print(text + "\n")
}

async function sleep(ms) {
    await cgt.tickSleep(ms)
}

function randomInt(min, max) {
    if ( min > max )
        throw new Error("randomInt: az első paraméter nem lehet nagyobb, mint a második.")
    return Math.floor(Math.random() * (max + 1 - min)) + min
}

let cgt = {}
;(_this => {
    // assets must be in format {images: [{name:, url:}, ...], sounds: [{name:, url:}, ...]}
    // returns a promise
    _this.loadAssets = function(assets) {
        return new Promise((resolve, reject) => {
            usePreloadSystem(false)
            if ( assets.images === undefined )
                assets.images = []
            if ( assets.sounds === undefined )
                assets.sounds = []
            let assetsLeft = assets.images.length + assets.sounds.length
            for ( let img of assets.images ) {
                loadImage(img.url).then(
                    (imgObj) => {
                        imgs[img.name] = imgObj
                        --assetsLeft
                        if ( assetsLeft <= 0 )
                            resolve()
                    },
                    () => {
                        reject("Error loading image: " + img.name)
                    }
                )
            }
            for ( let sound of assets.sounds ) {
                loadSound(sound.url).then(
                    (soundObj) => {
                        sounds[sound.name] = soundObj
                        --assetsLeft
                        if ( assetsLeft <= 0 )
                            resolve()
                    },
                    (err) => {
                        reject("Error loading sound: " + sound.name + ". " + err.message)
                    }
                )
            }
        })
    }

    _this.getImg = function(name) {
        if ( imgs[name] === undefined )
            throw new Error("Image doesn't exist: " + name)
        return imgs[name]
    }

    _this.getSnd = function(name) {
        if ( sounds[name] === undefined )
            throw new Error("Sound doesn't exist: " + name)
        return sounds[name]
    }

    _this.loadSolution = function() {
        return new Promise((resolve, reject) => {
            loadText('solution.js', (res) => {
                if ( typeof res === 'string' && !res.startsWith('<!DOCTYPE html>') ) {
                    solution = res
                    resolve(res)
                } else
                    reject("Nem található a megoldás.")
            })
        })
    }

    _this.runSolution = function() {
        if ( solutionScriptEl !== null )
            solutionScriptEl.remove();
        solutionScriptEl = document.createElement('div')
        document.body.appendChild(solutionScriptEl)
        let fragment = document.createRange()
            .createContextualFragment(`<script>
                (async ()=>{
                    try {
                        ${solution}
                    } catch ( e ) {
                        if ( typeof e === 'object' && e !== null && typeof e.message === 'string' )
                            console.error(e.message)
                        else
                            console.error(e)
                    }
                })()
            </script>`)
        // exceptions thrown in the solution won't propogate here, they will be uncaught in the other
        // script tag.
        solutionScriptEl.append(fragment)
    }

    _this.sText = function(text, x, y, size, options = {}) {
        textSize(1)
        let result = new Sprite(x, y)
        result.collider = 'static'
        result.textSize = size
        if ( options.color !== undefined )
            result.textColor = options.color
        if ( options.stroke !== undefined )
            result.textStroke = options.stroke
        result.text = text
        result.layer = (options.layer || 1000)
        result.fill = result.stroke = color(0, 0, 0, 0)
        if ( options.group !== undefined ) {
            if ( textGroups[options.group] !== undefined )
                textGroups[options.group].push(result)
            else
                textGroups[options.group] = [result]
        }
        return result
    }

    _this.hideSTexts = function(...groups) {
        for ( const group of groups ) {
            if ( textGroups[group] === undefined )
                continue
            for ( let sText of textGroups[group] )
                sText.remove()
            delete textGroups[group]
        }
    }

    _this.getTick = function(time = performance.now()) {
        return tickData.startVal + (time - tickData.startTime) * tickData.speed
    }

    _this.getTimeFromTick = function(tick) {
        return tickData.startTime + (tick - tickData.startVal) / tickData.speed
    }

    _this.setGameSpeed = function(val) {
        if ( tickData.speed === val )
            return
        const now = performance.now()
        tickData.startVal = _this.getTick(now)
        tickData.startTime = now
        tickData.speed = val
        for ( const timer of tickData.timers )
            updateTickTimerTimeout(timer, now)
    }

    _this.getGameSpeed = function() {
        return tickData.speed
    }

    _this.setTickTimeout = function(callback, tick) {
        let now = performance.now()
        let timer = {
            endTick: _this.getTick(now) + tick,
            timeoutId: null,
            callback
        }
        tickData.timers.push(timer)
        updateTickTimerTimeout(timer, now)
        return timer
    }

    _this.clearTickTimeout = function(timer) {
        const index = tickData.timers.indexOf(timer)
        if ( index !== -1 ) {
            const timeoutId = tickData.timers[index].timeoutId
            if ( timeoutId !== null )
                clearTimeout(timeoutId)
            tickData.timers.splice(index, 1)
        }
    }

    // returns a promise
    _this.tickSleep = function(tick) {
        return new Promise(resolve => {
            _this.setTickTimeout(resolve, tick)
        })
    }

    _this.sleep = function(ms) {
        return new Promise(resolve => {
            setTimeout(resolve, ms)
        })
    }

    // dir: {x: , y:}
    _this.floatSprite = function(sprite, dir, durationTick) {
        dir = Object.assign({}, dir)
        if ( dir.x === undefined )
            dir.x = 0;
        if ( dir.y === undefined )
            dir.y = 0;
        let ms = findMovedSprite(sprite)
        const float = {dir, durationTick, startTick: _this.getTick()}
        if ( ms === null ) {
            ms = {
                sprite,
                center: {x: sprite.x, y: sprite.y},
                float
            }
            movedSprites.push(ms)
            setupMovedSpriteUpdate(ms)
        } else
            ms.float = float
    }

    // speedOrDuration must be either {durationTick: } or {speedPxPerTickS: }
    _this.moveSprite = function(sprite, to, speedOrDuration) {
        if ( speedOrDuration.durationTick === undefined &&
                speedOrDuration.speedPxPerTickS === undefined)
            throw new Error("Invalid speedOrDuration in moveSprite")
        let ms = findMovedSprite(sprite)
        if ( ms === null ) {
            ms = {
                sprite,
                center: {x: sprite.x, y: sprite.y}
            }
            movedSprites.push(ms)
            setupMovedSpriteUpdate(ms)
        } else {
            if ( ms.move !== undefined )
                ms.move.resolve(false)
            else if ( ms.orbit !== undefined )
                delete ms.orbit
        }
        let durationTick
        if ( speedOrDuration.durationTick !== undefined )
            durationTick = speedOrDuration.durationTick
        else {
            const distPx = Math.sqrt((to.x - ms.center.x) ** 2 + (to.y - ms.center.y) ** 2)
            durationTick = distPx / speedOrDuration.speedPxPerTickS * 1000
        }
        ms.move = {
            to: Object.assign({}, to),
            startTick: _this.getTick(),
            durationTick,
            from: Object.assign({}, ms.center)
        }
        return new Promise((resolve, reject) => {
            ms.move.resolve = resolve
        })
    }

    // speed must be either {degPerTickS: } or {pxPerTickS: } (circumferential velocity)
    _this.orbitSprite = function(sprite, center, speed) {
        if ( speed.degPerTickS === undefined && speed.pxPerTickS === undefined )
            throw new Error("Invalid speed in orbitSprite")
        let ms = findMovedSprite(sprite)
        if ( ms === null ) {
            ms = {
                sprite,
                center: {x: sprite.x, y: sprite.y}
            }
            movedSprites.push(ms)
            setupMovedSpriteUpdate(ms)
        } else {
            if ( ms.move !== undefined ) {
                ms.move.resolve(false)
                delete ms.move
            }
        }
        const centerDiff = {x: ms.center.x - center.x, y: ms.center.y - center.y}
        const distFromCenter = Math.sqrt(centerDiff.x ** 2 + centerDiff.y ** 2)
        let degPerTickS
        if ( speed.degPerTickS !== undefined )
            degPerTickS = speed.degPerTickS
        else if ( distFromCenter !== 0.0 )
            degPerTickS = speed.pxPerTickS / distFromCenter / Math.PI * 180
        else
            degPerTickS = 0
        ms.orbit = {
            center,
            distFromCenter,
            degPerTickS,
            startTick: _this.getTick(),
            startDeg: getDeg(centerDiff, distFromCenter)
        }
    }

    _this.stopMovedSprite = function(sprite) {
        for ( let i = 0; i < movedSprites.length; ++i ) {
            let ms = movedSprites[i]
            if ( ms.sprite === sprite ) {
                ms.sprite.update = null
                ms.sprite.x = ms.center.x
                ms.sprite.y = ms.center.y
                movedSprites.splice(i, 1)
                if ( ms.move !== undefined )
                    ms.move.resolve(false)
                return
            }
        }
        console.error("stopMovedSprite: Sprite is not moved.")
    }

    _this.showSpeedButtons = async function(xOffset = 300) {
        if ( tickData.speedBtns !== null )
            return
        tickData.speedBtns = false
        await _this.loadAssets({images: [
            {name: 'speedPaused', url: assetsPrefix + "/speed_paused.png"},
            {name: 'speedNormal', url: assetsPrefix + "/speed_normal.png"},
            {name: 'speedFast', url: assetsPrefix + "/speed_fast.png"},
            {name: 'speedFaster', url: assetsPrefix + "/speed_faster.png"}
        ]})
        if ( tickData.speedBtns === null )
            return
        let sPaused = sprite(cgt.getImg("speedPaused"), 22 + xOffset, 22, 0.5),
            sNormal = sprite(cgt.getImg("speedNormal"), 62 + xOffset, 22, 0.5),
            sFast = sprite(cgt.getImg("speedFast"), 102 + xOffset, 22, 0.5),
            sFaster = sprite(cgt.getImg("speedFaster"), 142 + xOffset, 22, 0.5);
        sPaused.onMousePresses = function() { cgt.setGameSpeed(0); };
        sNormal.onMousePresses = function() { cgt.setGameSpeed(1); };
        sFast.onMousePresses = function() { cgt.setGameSpeed(3); };
        sFaster.onMousePresses = function() { cgt.setGameSpeed(20); };
        tickData.speedBtns = [sPaused, sNormal, sFast, sFaster];
    }

    _this.removeSpeedButtons = function() {
        if ( tickData.speedBtns === null )
            return
        if ( tickData.speedBtns === false ) {
            tickData.speedBtns = null
            return
        }
        for ( const sBtn of tickData.speedBtns )
            sBtn.remove();
        tickData.speedBtns = null;
    }


    let imgs = {}, sounds = {}
    let textGroups = {}
    let tickData = {
        speed: 1.0,
        startTime: performance.now(),
        startVal: 0,
        timers: [],
        speedBtns: null // false while loading
    }
    let movedSprites = []
    let solution = null
    let solutionScriptEl = null

    function updateTickTimerTimeout(timer, now = performance.now()) {
        if ( timer.timeoutId !== null )
            clearTimeout(timer.timeoutId)
        let interval = _this.getTimeFromTick(timer.endTick) - now
        if ( interval < 0 )
            interval = 0
        if ( interval > 2147483647 ) {
            // we treat intervals above the maximum setTimeout length as Infinity
            timer.timeoutId = null
            return
        }
        timer.timeoutId = setTimeout(() => {
            const index = tickData.timers.indexOf(timer)
            if ( index !== -1 )
                tickData.timers.splice(index, 1)
            timer.callback()
        }, interval)
    }

    function setupMovedSpriteUpdate(movedSprite) {
        let sprt = movedSprite.sprite
        movedSprite.sprite.update = () => {
            //movedSprite.update.apply(sprt)
            const now = _this.getTick()

            const move = movedSprite.move
            if ( move !== undefined ) {
                if ( now >= move.startTick + move.durationTick ) {
                    movedSprite.center = Object.assign({}, move.to)
                    movedSprite.move.resolve(true)
                    delete movedSprite.move
                    if ( movedSprite.float === undefined ) {
                        _this.stopMovedSprite(sprt)
                        return
                    }
                } else {
                    const ratio = ((now - move.startTick) / move.durationTick)
                    movedSprite.center.x = move.from.x + (move.to.x - move.from.x) * ratio
                    movedSprite.center.y = move.from.y + (move.to.y - move.from.y) * ratio
                }
            }

            const orbit = movedSprite.orbit
            if ( orbit !== undefined ) {
                const deg = orbit.startDeg + (now - orbit.startTick) * orbit.degPerTickS / 1000
                const rad = deg * Math.PI / 180
                movedSprite.center.x = orbit.center.x + Math.cos(rad) * orbit.distFromCenter
                movedSprite.center.y = orbit.center.y - Math.sin(rad) * orbit.distFromCenter
            }

            const float = movedSprite.float
            if ( float !== undefined ) {
                const phase = ((now - float.startTick) / float.durationTick) % 1;
                const offsetRatio = Math.sin(phase * 2 * Math.PI);
                sprt.x = movedSprite.center.x + float.dir.x * offsetRatio;
                sprt.y = movedSprite.center.y + float.dir.y * offsetRatio;
            } else {
                sprt.x = movedSprite.center.x
                sprt.y = movedSprite.center.y
            }
        }
    }

    function findMovedSprite(sprite) {
        for ( const ms of movedSprites )
            if ( ms.sprite === sprite )
                return ms
        return null
    }

    function getDeg(vec, length = null) {
        if ( length === null )
            length = Math.sqrt(vec.x ** 2 + vec.y ** 2)
        if ( length === 0 )
            return 0
        let deg = Math.acos(vec.x / length) * 180 / Math.PI
        if ( vec.y > 0 )
            deg = 360 - deg
        return deg
    }
})(cgt)
createCanvas()
resizeCanvas(800, 600)

let printPos = {x: 0, y: 0}
let sPrintedTexts = []
window.print = function(txt) {
    txt = new String(txt)
    txt = txt.replace(/\n/g, " ") + (txt.endsWith("\n") ? "\n" : "")
    const printSize = 20
    const lineGap = 1.2
    textSize(printSize)
    let width = textWidth(txt)
    let pt = cgt.sText(txt, printPos.x + width / 2, printPos.y + printSize / 2 * lineGap, printSize)
    sPrintedTexts.push(pt)
    if  ( txt.endsWith('\n') ) {
        printPos.y += printSize * lineGap
        printPos.x = 0
    } else
        printPos.x += width
    if ( printPos.y > 600 ) {
        let diff = printPos.y - 600
        for ( let i = sPrintedTexts.length - 1; i >= 0; --i ) {
            const sPT = sPrintedTexts[i]
            sPT.y -= diff
            if ( sPT.y + printSize * lineGap < 0 ) {
                sPT.remove()
                sPrintedTexts.splice(i, 1)
            }
        }
        printPos.y = 600
    }
}

function windowResized() {
   resizeCanvas(800, 600)
}

// * E1.hunt

let hunt = {}
let gameStarted = false
;(async (_this) => {

const TREECOUNT = 9

let imageAssets = [
    {name: 'hunter', url: currentPrefix + "/hunter.png"},
    {name: 'rabbit', url: currentPrefix + "/rabbit.png"},
    {name: 'diamond', url: currentPrefix + "/diamond.png"},
    {name: 'pirate', url: currentPrefix + "/pirate.png"}
]
for ( let i = 1; i <= TREECOUNT; ++i )
    imageAssets.push({name: 'tree' + i, url: currentPrefix + "/tree" + i + ".png"})

const assets = {images: imageAssets};

function rmRndArrayElem(array) {
    if ( !array.length )
        throw new Error("Can't get a random element of an empty array")
    const id = Math.floor(Math.random() * array.length)
    return array.splice(id, 1)[0]
}

let staticTrees = []
for ( let i = 0; i < 48; ++i )
    staticTrees.push("tree" + randomInt(1, TREECOUNT))

let places = Array(48).fill(null)
let sPlaces = Array(48).fill(null)

function assertPlaceId(id) {
    if ( !Number.isInteger(id) || id < 0 || id >= 48 )
        throw new Error("Érvénytelen place id: " + id)
}

function assertPlaceValue(value) {
    const values = [null, 'tree', 'hunter', 'rabbit', 'diamond', 'pirate']
    if ( !values.includes(value) )
        throw new Error("Nem létező place érték: " + val)
}

_this.showNumbers = function(show = true) {
    cgt.hideSTexts('numbers')
    if ( !show )
        return
    let no = 0
    for ( let y = 90; y < 600; y += 100 )
        for ( let x = 90; x < 800; x += 100 )
            cgt.sText(no++, x, y, 10, {group: 'numbers', color: 'grey'})
}

_this.place = function(id) {
    assertPlaceId(id)
    return places[id]
}

_this.setPlace = function(id, value) {
    assertPlaceId(id)
    assertPlaceValue(value)
    places[id] = value
    if ( sPlaces[id] !== null )
        sPlaces[id].remove()
    if ( value !== null ) {
        const imgName = (value !== 'tree' ? value : staticTrees[id])
        const x = id % 8 * 100 + 50, y = Math.floor(id / 8) * 100 + 50
        sPlaces[id] = sprite(cgt.getImg(imgName), x, y, 0.5)
        sPlaces[id].layer = 10
    } else
        sPlaces[id] = null
}

background('black')
fill('white')
textSize(30);
textAlign(CENTER, CENTER)
text("Betöltés...", 400, 300)

try {
    await Promise.all([
        cgt.loadAssets(assets),
        cgt.loadSolution()
    ])
} catch ( e ) {
    background('white')
    fill('red')
    textSize(14)
    text("Hiba történt a betöltés során:\n" + e, 400, 300, 800)
    return
}

background('white')
_this.showNumbers()
cgt.runSolution()
gameStarted = true

})(hunt)

function draw() {
    if ( !gameStarted )
        return
    background('white')
}

function showNumbers(show = true) {
    hunt.showNumbers(show)
}

function place(id) {
    return hunt.place(id)
}

function setPlace(id, value) {
    hunt.setPlace(id, value)
}

function f1() {
    for ( let i = 0; i < 48; ++i )
        setPlace(i, 'tree')
    setPlace(randomInt(0, 47), 'rabbit')
}
