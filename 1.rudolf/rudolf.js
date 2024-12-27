function rs() {


// * * * Megoldás * * *

function solution() {
    for ( let i = 0; i < 4; ++i ) {
        if ( slot(i) === 'G' )
            take(i);
        else if ( slot(i) === 'B' ) {
            defuse(i);
        }
    }
}

// * * *

solution(); }

// * CGTools *

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
let state = {config: null, points: 0, blownUpBombNo: null};
let history = [];

function init() {
    clear();
    sBg = sprite(cgt.getImg('background'), 400, 300, 0.5);
    sBg.depth = -100;
    createSlots();
}

function createSlots() {
    fill('white');
    for ( let i = 0; i < 4; ++i ) {
        let sSlot = sprite(cgt.getImg('slot'), (1/8+i/4)*800, 525, 0.5);
        sSlots.push(sSlot);
        text(i, (1/8+i/4)*800, 575);
    }
}

function removeItems() {
    for ( let sItem of sItems )
        sItem.remove();
    sItems = [];
}

function setConfig(config) {
    state.config = [...config];
    state.points = 0;
    state.blownUpBombNo = null;
    history = [];
    displayState();
}

function displayState() {
    removeItems();
    for ( let i = 0; i < 4; ++i ) {
        if ( state.config[i] === '' )
            continue;
        const name = state.config[i] === 'G' ? 'gift' : 'bomb';
        let sItem = sprite(cgt.getImg(name), (1/8+i/4)*800, 445, 0.25);
        cgt.floatSprite(sItem, {y: 9}, 900);
        sItems.push(sItem);
    }
}

function updateState(historyElement) {
    if ( state.blownUpBombNo !== null )
        return;
    if ( historyElement.action === 'take' ) {
        if ( state.config[historyElement.no] === 'G' ) {
            state.config[historyElement.no] = '';
            state.points += 2;
        } else if ( state.config[historyElement.no] === 'B' )
            state.blownUpBombNo = historyElement.no;
    } else if ( historyElement.action === 'defuse' ) {
        if ( state.config[historyElement.no] === 'B' ) {
            state.config[historyElement.no] = '';
            state.points += 1;
        } else
            state.blownUpBombNo = historyElement.no;
    } else if ( historyElement.action === 'conjure' ) {
        if ( state.config[historyElement.no] === 'G' )
            state.config[historyElement.no] = 'B';
        else if ( state.config[historyElement.no] === 'B' )
            state.config[historyElement.no] = 'G';
    }
}

function assertSlotNoValid(no, action) {
    if ( !Number.isInteger(no) || no < 0 || no >= 4 ) {
        history.push({action: 'invalidno', function: action, no});
        throw new ExitTestError();
    }
}

function slotAction(action, no) {
    assertSlotNoValid(no, action);
    const historyElement = {action, no};
    history.push(historyElement);
    updateState(historyElement);
    if ( state.blownUpBombNo !== null )
        throw new ExitTestError();
}

window.slot = function(no) {
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
    setConfig(testConfigs[0]);
    runTest();
    runTest();
}

async function runTest() {
    try {
        rs();
    } catch ( e ) {
        if ( !(e instanceof ExitTestError) )
            throw e;
    }
    console.log({state, history});
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
