let imgsToLoadCnt = 0;
let imgs = {};

function imageLoadError() {
    clear();
    textSize(20);
    text("Sajnos nem sikerült betölteni a képeket.", 400, 300);
}

function loadDinoImage(name, url) {
    ++imgsToLoadCnt;
    loadImage(url, function(img) {
        imgs[name] = img;
        --imgsToLoadCnt;
        if ( imgsToLoadCnt <= 0 )
            start();
    }, imageLoadError);
}

textSize(30);
textAlign(CENTER, CENTER);
text("Betöltés...", 400, 300);

loadDinoImage('bg', "https://raw.githubusercontent.com/trivia211/dinos_asset/main/hatter.jpg");
loadDinoImage('dino1', "https://raw.githubusercontent.com/trivia211/dinos_asset/main/dino1.png");
loadDinoImage('dino2', "https://raw.githubusercontent.com/trivia211/dinos_asset/main/dino2.png");
loadDinoImage('cactus1', "https://raw.githubusercontent.com/trivia211/dinos_asset/main/cactus1.png");
loadDinoImage('cactus2', "https://raw.githubusercontent.com/trivia211/dinos_asset/main/cactus2.png");
loadDinoImage('viktor', "https://raw.githubusercontent.com/trivia211/dinos_asset/main/viktor.jpg");
loadDinoImage('adri', "https://raw.githubusercontent.com/trivia211/dinos_asset/main/adri.png");
let gameOverSound = loadSound("https://raw.githubusercontent.com/trivia211/dinos_asset/main/game%20over.mp3");
let viktor1Sound = loadSound("https://raw.githubusercontent.com/trivia211/dinos_asset/main/viktor1.mp3");
let viktor2Sound = loadSound("https://raw.githubusercontent.com/trivia211/dinos_asset/main/viktor2.mp3");
let adriSound = loadSound("https://raw.githubusercontent.com/trivia211/dinos_asset/main/adri.mp3");

let started = false;
let bgS, dinoS, groundS;
let cactuses = new Group();
const adriY = 180;

function start() {
    clear();
    bgS = sprite(imgs.bg, 400, 300, 0.95);
    bgS.depth = -1;
    dinoS = sprite({Standing: [imgs.dino1], Jumping: [imgs.dino2]}, 70, 476, 0.45);
    dinoS.setCollider('rectangle', 30, 0, 210, 400);
    adriS = sprite(imgs.adri, 110, adriY, 0.2);
    adriS.velocity.y = 0.8;
    adriS.visible = false;
    groundS = createSprite(0, 566, 800, 0);
    started = true;
}

let gameOverTime = null;

function setGameOver() {
    textSize(50);
    text("GAME OVER", 400, 300);
    for ( let cactusS of cactuses ) {
        cactusS.velocity.x = 0;
        cactusS.life = -1;
    }
    if ( viktorStatus !== null ) {
        viktorS.velocity.x = 0;
        viktorS.rotationSpeed = 0;
    }
    adriS.velocity.y = 0;
    dinoS.velocity.y = 0;
    gameOverTime = frameCount;
    gameOverSound.play();
}

function printPoints() {
    textSize(30);
    text(points - cactuses.length, 30, 20);
}

function spawnCactus(no) {
    let cactusS = sprite(imgs["cactus" + no], 844.85, 511, 0.3);
    cactusS.setCollider('rectangle', 0, 0, 200, 450);
    cactusS.velocity.x = -6.5;
    cactusS.life = 140;
    cactuses.add(cactusS);
    points += 1;
}

function spawnCactuses() {
    if ( frameCount % 60 !== 0 ||
            (viktorStatus !== null && viktorStatus !== 'attack' &&
                viktorStatus !== 'scare') ||
            random() < 0.5)
        return;
    spawnCactus(floor(random()*2)+1);
}

let viktorStatus = null;
let viktorStart = null;
let viktorS = null;

function spawnViktor() {
    if  ( viktorStatus  === null ) {
        const viktorFreq = 15; // seconds, avarage
        if ( random() >= 1 / 60 / viktorFreq )
            return;
        viktor1Sound.play();
        viktorS = sprite(imgs['viktor'], 710, 511, 0.84375);
        viktorStart = frameCount;
        viktorStatus = 'scare';
    } else if ( viktorStatus === 'scare' ) {
        if ( frameCount - viktorStart > 100 ) {
            viktorStatus = 'rotate';
            viktorS.rotationSpeed = -8;
        }
    } else if ( viktorStatus === 'rotate' ) {
        if ( viktorS.rotation <= -720 ) {
            viktorStatus = 'rotate';
            viktorS.rotationSpeed = 0;
            viktorS.rotation = 0;
            viktorS.velocity.x = -38;
            viktorStatus = 'attack';
            viktor2Sound.play();
        }
    } else if ( viktorStatus === 'attack' ) {
        if ( frameCount - viktorStart > 210 ) {
            viktorS.remove();
            viktorStatus = null;
            points += 10;
        } else if ( viktorS.overlap(dinoS) ) {
            setGameOver();
            return;
        }
    }
}

let adriStart = null;

function spawnAdri() {
    const ampl = 15;
    if ( adriS.velocity.y >= 0 && adriS.y > adriY + ampl)
        adriS.velocity.y = -0.8;
    else if ( adriS.velocity.y < 0 && adriS.y < adriY - ampl)
        adriS.velocity.y = 0.8;
    if ( adriStart === null ) {
        const adriFreq = 30; // seconds, avarage
        if ( random() >= 1 / 60 / adriFreq )
            return;
        adriSound.play();
        adriS.visible = true;
        adriStart = frameCount;
    } else {
        if ( frameCount - adriStart >= 330 ) {
            adriStart = null;
            adriS.visible = false;
        }
    }
}

let jumping = false;
let points = 0;

function loop() {
    if ( !started )
        return;
    if ( gameOverTime !== null ) {
        if ( frameCount - gameOverTime > 60 &&
                ((keyIsPressed && keyCode === 32) ||
                    (mouseIsPressed && mouseButton === LEFT)) ) {
            while ( cactuses.length )
                cactuses[0].remove();
            if ( viktorStatus !== null ) {
                viktorStatus = null;
                viktorS.remove();
            }
            adriStart = null;
            adriS.visible = false;
            adriS.velocity.y = 0.8;
            points = 0;
            gameOverTime = null;
        }
        return;
    }
    clear();
    printPoints();
    if ( dinoS.overlap(cactuses) ) {
        setGameOver();
        return;
    }
    if ( !jumping ) {
        if ( (keyIsPressed && keyCode === 32) ||
                (mouseIsPressed && mouseButton === LEFT) ) {
            dinoS.velocity.y = -21;
            dinoS.x += 30;
            dinoS.show("Jumping");
            dinoS.setCollider('rectangle', 0, 0, 170, 350);
            jumping = true;
        }
    } else {
        if ( dinoS.collide(groundS) ) {
            dinoS.velocity.y = 0;
            dinoS.setCollider('rectangle', 30, 0, 210, 400);
            dinoS.x = 70;
            dinoS.y = 476;
            dinoS.show("Standing");
            jumping = false;
        } else if ( adriStart !== null && abs(dinoS.velocity.y) < 0.8 ) {
            dinoS.velocity.y = 0;
            if ( (keyIsPressed && keyCode === 32) ||
                    (mouseIsPressed && mouseButton === LEFT) ) {
                adriStart = null;
                adriS.visible = false;
            }
        } else
            dinoS.velocity.y += 0.8;
    }
    spawnViktor();
    spawnAdri();
    spawnCactuses();
}
