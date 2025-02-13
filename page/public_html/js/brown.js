$(document).ready(function() {
    let snowQ
    let resizeTimer = null
    let flakes = []
    let flakeProb = 0.0
    let size

    function setupAnimation() {
        flakes = []
        flakeProb = Math.min(size.w / 8000, 1)
    }

    function moveFlakes() {
        const turb = 1.5
        const speed = 1.2
        for ( let i = flakes.length - 1; i >= 0; --i ) {
            if ( snowQ.frameCount % 2 === 0 ) {
                flakes[i].x += Math.random() * turb * 2 - turb
                flakes[i].y += Math.random() * turb * 2 - turb
            }
            flakes[i].y -= speed
            if ( flakes[i].y < 0 ) {
                flakes.splice(i, 1)
                continue
            }
        }
    }

    function spawnFlakes() {
        if ( Math.random() < flakeProb )
            flakes.push({
                x: Math.random() * size.w,
                y: size.h
            })
    }

    function drawFlakes() {
        for ( const flake of flakes )
            snowQ.point(flake.x, flake.y)
    }

    function getSnowSize() {
        let cont = $("#snow-container")
        return {w: cont.width(), h: cont.height()}
    }


    snowQ = new Q5('instance', $("#snow-container")[0])

    snowQ.setup = function() {
        size = getSnowSize()
        snowQ.createCanvas(size.w, size.h, {alpha: true})
        snowQ.frameRate(40)
        snowQ.stroke('red')
        snowQ.strokeWeight(5)
        setupAnimation()
    }

    snowQ.windowResized = function() {
        if ( resizeTimer === null )
            snowQ.clear()
        else
            clearTimeout(resizeTimer)
        resizeTimer = setTimeout(() => {
            resizeTimer = null
            size = getSnowSize()
            snowQ.resizeCanvas(size.w, size.h)
            setupAnimation()
        }, 100)
    }

    snowQ.draw = function() {
        if ( resizeTimer !== null )
            return;
        snowQ.clear()
        moveFlakes()
        spawnFlakes()
        drawFlakes()
    }
})
