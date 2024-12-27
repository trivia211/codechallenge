
// * CGTools *

const repoPrefix = "https://raw.githubusercontent.com/trivia211/codechallenge_asset/main";

let cgtAssets = {};
(_this => {
    // assets must be in format {images: [{name:, url:}, ...], sounds: [{name:, url:}, ...]}
    // returns a promise
    _this.load = function(assets) {
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

    let imgs = {}, sounds = {};
})(cgtAssets);

// * 1. Rudolf *
let callbacks = (function() {

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

let gameState = 'loading';
let sBg;
let sSlots = [];
let sItems = [];

clear();
textSize(30);
textAlign(CENTER, CENTER);
text("Betöltés...", 400, 300);

cgtAssets.load(assets).then(() => {
    clear();
    start();
}).catch(err => {
    clear();
    fill('red');
    textSize(14);
    text("Hiba történt a betöltés során: " + err, 0, 300, 800);
});

function start() {
    sBg = sprite(cgtAssets.getImg('background'), 400, 300, 0.5);
    sBg.depth = -100;
    createSlots();
    gameState = 'running';
}

function createSlots() {
    for ( let i = 0; i < 4; ++i ) {
        let sSlot = sprite(cgtAssets.getImg('slot'), (1/8+i/4)*800, 500, 0.5);
        sSlots.push(sSlot);
    }
}

function removeItems() {
    for ( let sItem of sItems )
        sItem.remove();
    sItems = [];
}

function displayConfig(config) {
}

function loop() {
    fill('white');
    for ( let i = 0; i < 4; ++i ) {
        text(i+1, (1/8+i/4)*800, 570);
    }
}

return { loop };

})();


function loop() {
    callbacks.loop();
}
