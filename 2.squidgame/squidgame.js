



// * CodeGuppyTools *

const assetsPrefix = "https://prog.vikweb.hu/assets"
const currentPrefix = assetsPrefix + "/1.squidgame"

let cgt = {};
(_this => {
    // assets must be in format {images: [{name:, url:}, ...], sounds: [{name:, url:}, ...]}
    // returns a promise
    _this.loadAssets = function(assets) {
        return new Promise((resolve, reject) => {
            if ( assets.images === undefined )
                assets.images = []
            if ( assets.sounds === undefined )
                assets.sounds = []
            let assetsLeft = assets.images.length + assets.sounds.length
            for ( let img of assets.images ) {
                loadImage(img.url, function(imgObj) {
                    imgs[img.name] = imgObj
                    --assetsLeft
                    if ( assetsLeft <= 0 )
                        resolve()
                }, function() {
                    reject("Error loading image: " + img.name)
                })
            }
            for ( let sound of assets.sounds ) {
                loadSound(sound.url, function(soundObj) {
                    sounds[sound.name] = soundObj
                    --assetsLeft
                    if ( assetsLeft <= 0 )
                        resolve()
                }, function(err) {
                    reject("Error loading sound: " + sound.name + ". " + err.message)
                })
            }
        })
    }

    _this.getImg = function(name) {
        if ( imgs[name] === undefined )
            throw "Image doesn't exist: " + name
        return imgs[name]
    }

    _this.getSnd = function(name) {
        if ( sounds[name] === undefined )
            throw "Sound doesn't exist: " + name
        return sounds[name]
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
                update: sprite.update,
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
                update: sprite.update,
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
                update: sprite.update,
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
                ms.sprite.update = ms.update
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
        sPaused.onMousePressed = function() { cgt.setGameSpeed(0); };
        sNormal.onMousePressed = function() { cgt.setGameSpeed(1); };
        sFast.onMousePressed = function() { cgt.setGameSpeed(3); };
        sFaster.onMousePressed = function() { cgt.setGameSpeed(20); };
        tickData.speedBtns = [sPaused, sNormal, sFast, sFaster];
    }

    _this.removeSpeedBtns = function() {
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
    let tickData = {
        speed: 1.0,
        startTime: performance.now(),
        startVal: 0,
        timers: [],
        speedBtns: null // false while loading
    }

    let movedSprites = []

    function updateTickTimerTimeout(timer, now = performance.now()) {
        if ( timer.timeoutId !== null )
            clearTimeout(timer.timeoutId)
        const interval = _this.getTimeFromTick(timer.endTick) - now
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
            movedSprite.update.apply(sprt)
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

let cmdRecorder = {};
(_this => {
    _this.clearCommands = function() {
        if ( recording )
            unregisterCommands()
        commands = {}
        recordedCommands = []
    }

    // when a global function called name is called: during recording recordFunc, during replay
    // replayFunc will be called. if any of those is null, it will not be called (it will still be
    // recorded). if replayFunc returns a Promise, it will be awaited for before continuing the replay.
    // if local is set, a locally defined function will be replaced using eval()
    // see also: setFuncFirstParam.
    _this.addCommand = function(name, recordFunc, replayFunc, local = false) {
        if ( commands[name] !== undefined )
            throw new Error(`${name} is already added`)
        let command = {recordFunc, replayFunc, local}
        commands[name] = command
        if ( recording )
            registerCommands({[name]: command})
    }

    _this.removeCommand = function(name) {
        if ( commands[name] === undefined )
            throw new Error(`${name} is not added`)
        if ( recording )
            unregisterCommands({[name]: commands[name]})
        delete commands[name]
        recordedCommands = recordedCommands.filter((rCmd) => rCmd.name !== name)
    }

    // if set to anything else then undefined, this value will be prepended to the parameter list of the
    // called recordFuncs and replayFuncs
    _this.setFuncFirstParam = function(param) {
        funcFirstParam = param
    }

    // clears recorded commands
    _this.startRecording = function() {
        _this.resumeRecording()
        recordedCommands = []
    }

    _this.resumeRecording = function() {
        if ( recording )
            throw new Error("Already recording")
        registerCommands()
        recording = true
    }

    _this.stopRecording = function() {
        if ( !recording )
            throw new Error("Recording hasn't started")
        unregisterCommands()
        recording = false
    }

    _this.getRecordedCommands = function() {
        return recordedCommands
    }

    _this.replay = async function() {
        for ( const cmd of recordedCommands ) {
            const func = commands[cmd.name].replayFunc
            if ( func === null )
                continue
            const res = callFunc(commands[cmd.name].replayFunc, cmd.args)
            if ( res instanceof Promise )
                await res
        }
    }


    let commands = {}
    let recording = false
    let funcFirstParam = undefined
    let recordedCommands = []

    function registerCommands(cmds = commands) {
        for ( const [name, cmd] of Object.entries(cmds) ) {
            const func = function(...args) {
                recordedCommands.push({name, args: structuredClone(args)})
                if ( cmd.recordFunc !== null )
                    return callFunc(cmd.recordFunc, args) // may throw
            }
            if ( !cmd.local ) {
                if ( window[name] !== undefined )
                    cmd.origFunc = window[name]
                window[name] = func
            } else {
                if ( eval(`typeof ${name}`) === 'undefined' )
                    throw new Error(`Local function ${name} doesn't exist`)
                cmd.origFunc = eval(name)
                eval(`${name} = func`)
            }
        }
    }

    function unregisterCommands(cmds = commands) {
        for ( const [name, cmd] of Object.entries(cmds) )
            if ( !cmd.local ) {
                if ( cmd.origFunc !== undefined ) {
                    window[name] = cmd.origFunc
                    delete cmd.origFunc
                } else
                    delete window[name]
            } else {
                eval(`${name} = cmd.origFunc`)
                delete cmd.origFunc
            }
    }

    function callFunc(func, args) {
        if ( funcFirstParam === undefined )
            return func(...args)
        else
            return func(funcFirstParam, ...args)
    }
})(cmdRecorder)
