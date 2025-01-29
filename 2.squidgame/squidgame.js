



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

    _this.setTickTimeout = function(callback, tickMs) {
        let now = performance.now()
        let timer = {
            endTick: _this.getTick(now) + tickMs,
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
    _this.sleep = function(tickMs) {
        return new Promise(resolve => {
            _this.setTickTimeout(resolve, tickMs)
        })
    }

    // dir: {x: , y:}
    _this.floatSprite = function(sprite, dir, tickDuration) {
        dir = Object.assign({}, dir)
        if ( dir.x === undefined )
            dir.x = 0;
        if ( dir.y === undefined )
            dir.y = 0;
        let ms = findMovedSprite(sprite)
        const float = {dir, tickDuration, startTick: _this.getTick()}
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

    _this.moveSprite = function(sprite, to, tickDuration) {
        let ms = findMovedSprite(sprite)
        const move = {to: Object.assign({}, to), startTick: _this.getTick(), tickDuration}
        if ( ms === null ) {
            ms = {
                sprite,
                update: sprite.update,
                center: {x: sprite.x, y: sprite.y},
                move
            }
            movedSprites.push(ms)
            setupMovedSpriteUpdate(ms)
        } else
            ms.move = move
        ms.move.from = Object.assign({}, ms.center)
    }

    _this.stopMovedSprite = function(sprite) {
        for ( let i = 0; i < movedSprites.length; ++i ) {
            let ms = movedSprites[i]
            if ( ms.sprite === sprite ) {
                ms.sprite.update = ms.update
                ms.sprite.x = ms.center.x
                ms.sprite.y = ms.center.y
                movedSprites.splice(i, 1)
                return
            }
        }
        console.error("stopMovedSprite: Sprite is not moved.")
    }

    _this.showSpeedButtons = async function(xOffset = 300) {
        await _this.loadAssets({images: [
            {name: 'speedPaused', url: assetsPrefix + "/speed_paused.png"},
            {name: 'speedNormal', url: assetsPrefix + "/speed_normal.png"},
            {name: 'speedFast', url: assetsPrefix + "/speed_fast.png"},
            {name: 'speedFaster', url: assetsPrefix + "/speed_faster.png"}
        ]})
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
        speedBtns: null
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
                if ( now >= move.startTick + move.tickDuration ) {
                    movedSprite.center = Object.assign({}, move.to)
                    if ( movedSprite.float === undefined ) {
                        _this.stopMovedSprite(sprt)
                        return
                    }
                    delete movedSprite.move
                } else {
                    const ratio = ((now - move.startTick) / move.tickDuration)
                    movedSprite.center.x = move.from.x + (move.to.x - move.from.x) * ratio
                    movedSprite.center.y = move.from.y + (move.to.y - move.from.y) * ratio
                    if ( movedSprite.float === undefined ) {
                        sprt.x = movedSprite.center.x
                        sprt.y = movedSprite.center.y
                    }
                }
            }

            const float = movedSprite.float
            if ( float !== undefined ) {
                const phase = ((now - float.startTick) / float.tickDuration) % 1;
                const offsetRatio = Math.sin(phase * 2 * Math.PI);
                sprt.x = movedSprite.center.x + float.dir.x * offsetRatio;
                sprt.y = movedSprite.center.y + float.dir.y * offsetRatio;
            }
        }
    }

    function findMovedSprite(sprite) {
        for ( const ms of movedSprites )
            if ( ms.sprite === sprite )
                return ms
        return null
    }
})(cgt)