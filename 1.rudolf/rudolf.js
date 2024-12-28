function rs() {


// * * * Megoldás * * *

function solution() {
    for ( let i = 0; i < 4; ++i ) {
        if ( slot(i) === 'G' ) {
            take(i);
        } else if ( slot(i) === 'B' ) {
            conjure(i);
            take(i);
        }
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
        if ( findFloatedSprite(sprite) !== null )
            return;
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
        floatSprites.push(fs);
    }

    _this.sleep = function(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    let imgs = {}, sounds = {};
    let floatSprites = [];

    function findFloatedSprite(sprite) {
        for ( const fs of floatSprites )
            if ( fs.sprite === sprite )
                return fs;
        return null;
    }
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
        {name: 'wand', url: urlPrefix + "/wand.png"}
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
let state = {config: null, points: 0, blownUpSlotNo: null};
let history = [];
let gameSpeed = 1.0;

function init() {
    clear();
    sBg = sprite(cgt.getImg('background'), 400, 300, 0.5);
    sBg.depth = -100;
    createSlots();
}

function createSlots() {
    for ( let i = 0; i < 4; ++i ) {
        let sSlot = sprite(cgt.getImg('slot'), (1/8+i/4)*800, 525, 0.5);
        sSlot.depth = -10;
        sSlots.push(sSlot);
    }
}

function updateSlotIds() {
    fill('white');
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
        await cgt.sleep(1200 / gameSpeed);
        let slotContent = state.config[he.no];
        if ( he.action === 'take' ) {
            if ( slotContent === 'G' )
                cgt.getSnd('acquire').play();
        } else if ( he.action === 'defuse' ) {
            if ( slotContent === 'B' )
                cgt.getSnd('acquire').play();
        } else {
            sAction.velocity = {x: 0, y: 3};
            await cgt.sleep(600 / gameSpeed);
            if ( slotContent !== '' )
                cgt.getSnd('action').play();
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
        let sBoom = sprite(cgt.getImg('boom'), 400, 300, 0.6);
        sBoom.depth = -5;
        await cgt.sleep(2000 / gameSpeed);
        sBoom.remove();
    } else if ( he.action === 'toomanyactions' ) {
        cgt.getSnd('boom').play();
        textSize(50);
        text("Túl sok műveletet próbálasz végrehajtani!", 0, 300, 800);
        textSize(30);
        await cgt.sleep(5000);
        updateCanvas();
    } else if ( he.action === 'invalidno' ) {
        cgt.getSnd('boom').play();
        textSize(50);
        text("Érvénytelen slot sorszám a '" + he.function + "' akció során: " + he.no, 0, 300, 800);
        textSize(30);
        await cgt.sleep(5000);
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
    for ( const action of solHistory ) {
        await cgt.sleep(1000 / gameSpeed);
        updateCanvas();
        let beforeResult = await playHistoryElementBeforeUpdate(action);
        updateState(action);
        displayState();
        await playHistoryElementAfterUpdate(action, beforeResult);
    }
    textSize(50); text("Rudolf végzett ezen a pályán.", 0, 300, 800); textSize(30);
    await cgt.sleep(2000 / gameSpeed);
}

clear();
textSize(30);
textAlign(CENTER, CENTER);
text("Betöltés...", 400, 300);

try {
    await cgt.loadAssets(assets);
} catch ( e ) {
    clear();
    fill('red');
    textSize(14);
    text("Hiba történt a betöltés során: " + err, 0, 300, 800);
    return;
}

init();
await runTests();

})();
