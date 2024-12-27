
// * CGTools *

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

const rUrlPrefix = "https://raw.githubusercontent.com/trivia211/codechallenge_asset/main/1.rudolf";

const rAssets = {
    images: [
        {name: 'background', url: rUrlPrefix + "/background.jpg"},
        {name: 'bomb', url: rUrlPrefix + "/bomb.png"},
        {name: 'boom', url: rUrlPrefix + "/boom.png"},
        {name: 'gift', url: rUrlPrefix + "/gift.png"},
        {name: 'screwdriver', url: rUrlPrefix + "/screwdriver.png"},
        {name: 'slot', url: rUrlPrefix + "/slot.png"},
        {name: 'take', url: rUrlPrefix + "/take.png"},
        {name: 'wand', url: rUrlPrefix + "/wand.png"}
    ],
    sounds: [
        {name: 'action', url: rUrlPrefix + "/action.mp3"},
        {name: 'boom', url: rUrlPrefix + "/boom.mp3"},
        {name: 'success', url: rUrlPrefix + "/success.mp3"}
    ]
};
let rGameState = 'loading';
let rBgS;

textSize(30);
textAlign(CENTER, CENTER);
text("Betöltés...", 400, 300);

cgtAssets.load(rAssets).then(() => {
    clear();
    rStart();
}).catch(err => {
    clear();
    fill('red');
    textSize(14);
    text("Hiba történt a betöltés során: " + err, 0, 300, 800);
});

function rStart() {
    rBgS = sprite(cgtAssets.getImg('background'), 400, 300, 0.5);
    rGameState = 'running';
}

function loop() {
    if ( rGameState !== 'running' )
        return;

}