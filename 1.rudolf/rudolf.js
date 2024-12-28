function rs() {


// * * * Megoldás * * *

function solution() {
    for ( let i = 0; i < 4; i = i + 1 ) {
        take(i);
        conjure(i);
    }
}

// * * *

solution(); }

// * CodeGuppyTools *

const repoPrefix = "https://raw.githubusercontent.com/trivia211/codechallenge_asset/main";

let cgt = {};
(_this => {
    // assets must be in format {images: [{name:, url:}, ...], sounds: [{name:, url:}, ...]}
    // returns a promise
    _this.loadAssets = function(assets) {
        return new Promise((resolve, reject) => {
            if ( assets.images === undefined )
                assets.images = [];
            if ( assets.sounds === undefined )
                assets.sounds = [];
            let assetsLeft = assets.images.length + assets.sounds.length;
            for ( let img of assets.images ) {
                loadImage(img.url, function(imgObj) {
                    imgs[img.name] = imgObj;
                    --assetsLeft;
                    if ( assetsLeft <= 0 )
                        resolve();
                }, function() {
                    reject("Error loading image: " + img.name);
                });
            }
            for ( let sound of assets.sounds ) {
                loadSound(sound.url, function(soundObj) {
                    sounds[sound.name] = soundObj;
                    --assetsLeft;
                    if ( assetsLeft <= 0 )
                        resolve();
                }, function(err) {
                    reject("Error loading sound: " + sound.name + ". " + err.message);
                });
            }
        });
    };

    _this.getImg = function(name) {
        if ( imgs[name] === undefined )
            throw "Image doesn't exist: " + name;
        return imgs[name];
    };

    _this.getSnd = function(name) {
        if ( sounds[name] === undefined )
            throw "Sound doesn't exist: " + name;
        return sounds[name];
    }

    // dir: {x: , y:}
    _this.floatSprite = function(sprite, dir, durationMs) {
        dir = Object.assign({}, dir);
        if ( dir.x === undefined )
            dir.x = 0;
        if ( dir.y === undefined )
            dir.y = 0;
        let fs = {sprite, x: sprite.x, y: sprite.y, update: sprite.update,
            startTime: performance.now()};
        sprite.update = function() {
            fs.update.apply(sprite);
            let phase = ((performance.now() - fs.startTime) / durationMs) % 1;
            let offsetRatio = Math.sin(phase * 2 * Math.PI);
            sprite.x = fs.x + dir.x * offsetRatio;
            sprite.y = fs.y + dir.y * offsetRatio;
        };
    }

    _this.setGameSpeed = function(val) {
        gameSpeed = val;
        if ( val === 0.0 ) {
            if ( gameRestart === null ) {
                gameRestart = {};
                gameRestart.promise = new Promise(resolve => {gameRestart.resolve = resolve});
            }
        } else if ( gameRestart !== null ) {
            let resolve = gameRestart.resolve;
            gameRestart = null;
            resolve();
        }
    }

    _this.getGameSpeed = function() {
        return gameSpeed;
    }

    _this.getDuration = function(gameMs) {
        if ( gameSpeed === 0.0 )
            return null;
        else
            return gameMs / gameSpeed;
    }

    _this.sleep = async function(gameMs) {
        await _this.gameResumed();
        let ms = _this.getDuration(gameMs);
        await _this.absoluteSleep(ms);
        await _this.gameResumed();
    }

    _this.absoluteSleep = function(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    _this.gameResumed = async function() {
        while ( gameRestart !== null )
            await gameRestart.promise;
    }



    let imgs = {}, sounds = {};
    let gameSpeed = 1.0;

    let gameRestart = null;
})(cgt);

// * 1. Rudolf *

(async function() {

class ExitTestError extends Error {
    constructor(message, options) {
        super(message, options);
    }
}

const urlPrefix = repoPrefix + "/1.rudolf/assets";

const assets = {
    images: [
        {name: 'background', url: urlPrefix + "/background.jpg"},
        {name: 'bomb', url: urlPrefix + "/bomb.png"},
        {name: 'boom', url: urlPrefix + "/boom.png"},
        {name: 'gift', url: urlPrefix + "/gift.png"},
        {name: 'screwdriver', url: urlPrefix + "/screwdriver.png"},
        {name: 'slot', url: urlPrefix + "/slot.png"},
        {name: 'take', url: urlPrefix + "/take.png"},
        {name: 'wand', url: urlPrefix + "/wand.png"},
        {name: 'speedPaused', url: repoPrefix + "/assets/speed_paused.png"},
        {name: 'speedNormal', url: repoPrefix + "/assets/speed_normal.png"},
        {name: 'speedFast', url: repoPrefix + "/assets/speed_fast.png"},
        {name: 'speedFaster', url: repoPrefix + "/assets/speed_faster.png"}
    ],
    sounds: [
        {name: 'action', url: urlPrefix + "/action.mp3"},
        {name: 'acquire', url: urlPrefix + "/acquire.mp3"},
        {name: 'boom', url: urlPrefix + "/boom.mp3"},
        {name: 'success', url: urlPrefix + "/success.mp3"}
    ]
};
const testConfigs = [
    ['G', 'G', 'B', 'G'],
    ['B', 'G', 'G', 'B'],
    ['G', 'B', 'B', 'G'],
    ['B', 'B', 'B', 'B'],
    ['B', 'G', 'G', 'G'],
    ['G', 'G', 'G', 'G']
];

let sBg;
let sSlots = [];
let sItems = [];
let sSpeedBtns = [];
let state = {config: null, points: 0, blownUpSlotNo: null};
let history = [];

function init() {
    clear();
    sBg = sprite(cgt.getImg('background'), 400, 300, 0.5);
    sBg.depth = -100;
    createSpeedButtons();
    createSlots();
    cgt.setGameSpeed(0.0);
}

function createSpeedButtons() {
    let offset = 300;
    let sPaused = sprite(cgt.getImg("speedPaused"), 22 + offset, 22, 0.5),
       sNormal = sprite(cgt.getImg("speedNormal"), 62 + offset, 22, 0.5),
       sFast = sprite(cgt.getImg("speedFast"), 102 + offset, 22, 0.5),
       sFaster = sprite(cgt.getImg("speedFaster"), 142 + offset, 22, 0.5);
    sPaused.onMousePressed = function() { cgt.setGameSpeed(0); };
    sNormal.onMousePressed = function() { cgt.setGameSpeed(1); };
    sFast.onMousePressed = function() { cgt.setGameSpeed(3); };
    sFaster.onMousePressed = function() { cgt.setGameSpeed(20); };
    sSpeedBtns = [sPaused, sNormal, sFast, sFaster];
}

function removeSpeedBtns() {
    for ( const btn of sSpeedBtns )
        btn.remove();
    sSpeedBtns = [];
}

function createSlots() {
    for ( let i = 0; i < 4; ++i ) {
        let sSlot = sprite(cgt.getImg('slot'), (1/8+i/4)*800, 525, 0.5);
        sSlot.depth = -10;
        sSlots.push(sSlot);
    }
}

function updateSlotIds() {
    for ( let i = 0; i < 4; ++i )
        text(i, (1/8+i/4)*800, 575);
}

function removeItems() {
    for ( let sItem of sItems )
        sItem.remove();
    sItems = [];
}

function setConfig(config) {
    state.config = [...config];
    state.points = 0;
    state.blownUpSlotNo = null;
    history = [];
}

function displayState() {
    removeItems();
    for ( let i = 0; i < 4; ++i ) {
        if ( state.config[i] === '' )
            continue;
        const name = state.config[i] === 'G' ? 'gift' : 'bomb';
        let sItem = sprite(cgt.getImg(name), (1/8+i/4)*800, 445, 0.25);
        sItem.depth = -10;
        cgt.floatSprite(sItem, {y: 9}, 900);
        sItems.push(sItem);
    }
    updateCanvas();
}

function updateCanvas() {
    clear();
    updateSlotIds();
    textAlign(RIGHT, TOP);
    text("Pontok: " + state.points, 790, 10);
    textAlign(CENTER, CENTER);

}

function updateState(historyElement) {
    if ( state.blownUpSlotNo !== null )
        return;
    if ( historyElement.action === 'take' ) {
        if ( state.config[historyElement.no] === 'G' )
            state.points += 2;
        else if ( state.config[historyElement.no] === 'B' ) {
            state.blownUpSlotNo = historyElement.no;
            --state.points;
        } else {
            state.points -= 0.5;
        }
        state.config[historyElement.no] = '';
    } else if ( historyElement.action === 'defuse' ) {
        if ( state.config[historyElement.no] === 'B' )
            ++state.points;
        else {
            state.blownUpSlotNo = historyElement.no;
            --state.points;
        }
        state.config[historyElement.no] = '';
    } else if ( historyElement.action === 'conjure' ) {
        if ( state.config[historyElement.no] === 'G' )
            state.config[historyElement.no] = 'B';
        else if ( state.config[historyElement.no] === 'B' )
            state.config[historyElement.no] = 'G';
        else
            state.points -= 0.5;
    } else if ( ['toomanyactions', 'invalidno'].includes(historyElement.action) )
        --state.points;
}

async function playHistoryElementBeforeUpdate(he) {
    if ( state.blownUpSlotNo !== null )
        return;
    if (  ['take', 'defuse', 'conjure'].includes(he.action) ) {
        cgt.getSnd('action').play();
        let iconNames = {take: 'take', defuse: 'screwdriver', conjure: 'wand'};
        let iconName = iconNames[he.action];
        let sAction = displayActionIcon(iconName, he.no);
        await cgt.sleep(1200);
        let slotContent = state.config[he.no];
        if ( he.action === 'take' ) {
            if ( slotContent === 'G' )
                cgt.getSnd('acquire').play();
            else if ( slotContent === '' )
                cgt.getSnd('boom').play();
        } else if ( he.action === 'defuse' ) {
            if ( slotContent === 'B' )
                cgt.getSnd('acquire').play();
        } else {
            sAction.velocity = {x: 0, y: 3 * cgt.getGameSpeed()};
            await cgt.sleep(600);
            if ( slotContent !== '' )
                cgt.getSnd('action').play();
            else
                cgt.getSnd('boom').play();
        }
        sAction.remove();
    }
    return true;
}

async function playHistoryElementAfterUpdate(he, beforeResult) {
    if ( beforeResult !== true )
        return;
    if ( state.blownUpSlotNo !== null ) {
        cgt.getSnd('boom').play();
        let sBoom = sprite(cgt.getImg('boom'), 400, 300, 0.5);
        sBoom.depth = -5;
        await cgt.sleep(2000);
        sBoom.remove();
    } else if ( he.action === 'toomanyactions' ) {
        cgt.getSnd('boom').play();
        textSize(50);
        text("Túl sok műveletet próbálasz végrehajtani!", 0, 300, 800);
        textSize(30);
        await cgt.absoluteSleep(5000);
        updateCanvas();
    } else if ( he.action === 'invalidno' ) {
        cgt.getSnd('boom').play();
        textSize(50);
        text("Érvénytelen slot sorszám a '" + he.function + "' akció során: " + he.no, 0, 300, 800);
        textSize(30);
        await cgt.absoluteSleep(5000);
        updateCanvas();
    }
}

function displayActionIcon(imgName, no) {
    let result = sprite(cgt.getImg(imgName), (1/8+no/4)*800, 340, 0.25);
    result.depth = -10;
    return result;
}

function assertNotTooManyActions() {
    ++actionCnt;
    if ( actionCnt > 20 ) {
        const historyElement = {action: 'toomanyactions'};
        history.push(historyElement);
        updateState(historyElement);
        throw new ExitTestError();
    }
}

function assertSlotNoValid(no, action) {
    if ( !Number.isInteger(no) || no < 0 || no >= 4 ) {
        const historyElement = {action: 'invalidno', function: action, no};
        history.push(historyElement);
        updateState(historyElement);
        throw new ExitTestError();
    }
}

function slotAction(action, no) {
    assertNotTooManyActions();
    assertSlotNoValid(no, action);
    const historyElement = {action, no};
    history.push(historyElement);
    updateState(historyElement);
    if ( state.blownUpSlotNo !== null )
        throw new ExitTestError();
}

let actionCnt;

window.slot = function(no) {
    assertNotTooManyActions();
    assertSlotNoValid(no, 'slot');
    return state.config[no];
}

window.take = function(no) {
    slotAction('take', no);
}

window.defuse = function(no) {
    slotAction('defuse', no);
}

window.conjure = function(no) {
    slotAction('conjure', no);
}

async function runTests() {
    for ( let i = 0; i < testConfigs.length; ++i )
        await runTest(testConfigs[i], i+1);
    textSize(50); text("Vége! Elért pontszám: " + state.points, 0, 300, 800); textSize(30);
    removeSpeedBtns();
    cgt.getSnd('success').play();
}

async function runTest(config, level) {
    let points = state.points;
    setConfig(config);
    state.points = points;
    actionCnt = 0;
    try {
        rs();
    } catch ( e ) {
        if ( !(e instanceof ExitTestError) )
            throw e;
    }
    const solHistory = history;
    setConfig(config);
    state.points = points;
    displayState();
    textSize(50); text(level + ". pálya", 0, 300, 800); textSize(30);
    await cgt.sleep(1000);
    updateCanvas();
    let first = true;
    for ( const action of solHistory ) {
        if ( !first ) {
            await cgt.sleep(1000);
            updateCanvas();
        } else
            first = false;
        let beforeResult = await playHistoryElementBeforeUpdate(action);
        updateState(action);
        displayState();
        await playHistoryElementAfterUpdate(action, beforeResult);
    }
    textSize(50); text("Rudolf végzett ezen a pályán.", 0, 300, 800); textSize(30);
    await cgt.sleep(2000);
    updateCanvas();
}

clear();
fill('white');
textSize(30);
textAlign(CENTER, CENTER);
text("Betöltés...", 400, 300);

try {
    await cgt.loadAssets(assets);
} catch ( e ) {
    clear();
    fill('red');
    textSize(14);
    text("Hiba történt a betöltés során: " + e, 0, 300, 800);
    return;
}

init();
textSize(50); text("Kattints a startra!", 0, 300, 800); textSize(30);
await cgt.gameResumed();
await runTests();

})();
