$(document).ready(function() {
    let snowQ
    let resizeTimer = null
    let flakes = []
    let flakeProb = 0.0
    let size

    function setupAnimation() {
        //flakes = []
        flakeProb = Math.min(size.w / 8000, 1)
    }

    function moveFlakes() {
        const turb = 1.5
        const speed = 1.2
        const fpsR = 30 / snowQ.frameRate()
        for ( let i = flakes.length - 1; i >= 0; --i ) {
            if ( snowQ.frameCount % 2 === 0 ) {
                flakes[i].x += (Math.random() * turb * 2 - turb) * fpsR
                flakes[i].y += (Math.random() * turb * 2 - turb) * fpsR
            }
            flakes[i].y -= speed * fpsR
            if ( flakes[i].y < -1 || flakes[i].y > size.h + 5 ||
                    flakes[i].x <= -10 || flakes[i].x >= size.w + 10 ) {
                flakes.splice(i, 1)
                continue
            }
        }
    }

    let spawnCounter = 0.0

    function spawnFlakes() {
        spawnCounter += Math.random() * flakeProb * 30 / snowQ.frameRate()
        while ( spawnCounter >= 1.0 ) {
            flakes.push({
                x: Math.random() * size.w,
                y: size.h
            })
            spawnCounter -= 1.0
        }
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
        snowQ.clear()
        moveFlakes()
        spawnFlakes()
        drawFlakes()
    }
})
