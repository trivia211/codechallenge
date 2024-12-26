let assets = {};
// assets
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

    _this.getSound = function(name) {
        if ( sounds[name] === undefined )
            throw "Sound doesn't exist: " + name;
        return sounds[name];
    }

    let imgs = {}, sounds = {};
})(assets);

export default { assets };
