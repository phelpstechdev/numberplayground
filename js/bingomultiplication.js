
var folder="images/bingo-multiplication/"
var bingocover=6;
var extraimages=[];
function makeBingoMultiplication( nMax1, nMax2,image, size) {
    function makeProducts() {
        var i;
        var n1;
        var n2;
        var n3;
        var a=[13,14,16,17,18,19,21,22,23,24];



        for (i = 0; i < nRows * (nColumns-1); i++) {
            if (i == 0) {
                n1 = Math.ceil(Math.random() * nMax1);
                if (a.indexOf(n1)==-1) {
                    n2 = Math.ceil(Math.random() * nMax2);
                }else {
                    n2=10;
                }
                n3 = n1 * n2;
            }
            else {
                do
                {
                    n1 = Math.ceil(Math.random() * nMax1);//1-9
                    if (a.indexOf(n1)==-1) {
                        n2 = Math.ceil(Math.random() * nMax2);
                    }else {
                        n2=10;
                    }
                    n3 = n1 * n2;
                }
                while (isSame(n3, aProducts));
            }
            aFactors.push([n1, n2]);
            aProducts.push(n3);
            if (i<size){

                aFactors.push([n2, n1]);
                aProducts.push(n3);
            }
        }
        shuffle(aProducts);
    }

    function showProblem() {
        var n = Math.floor(Math.random()*aFactors.length);//0-?
        nWrong = 0;
        nCurrentFactorPair =n; //0-?
        nFactor1 = aFactors[nCurrentFactorPair][0];
        nFactor2 = aFactors[nCurrentFactorPair][1];
        Bingo.tProblem.text = nFactor1 + " X " + nFactor2 + " = ?";
    }
    function clickBoardPiece(evt) {
        var nClicked = +evt.currentTarget.tNumber.text;
        var nProduct = nFactor1*nFactor2;
        if (nClicked === nProduct) {
            evt.currentTarget.setImage(1);
            evt.currentTarget.cursor = "default";
            evt.currentTarget.removeEventListener("click", clickBoardPiece);
            if (nProblem >= nRows) {
                if (checkBingo()) {
                    Bingo.showWin();
                    Sound.playWinningPiece();
                    determineBingoPosition();
                    turnOffTiles();
                    //console.log("WINNER");
                } else {
                    Sound.playCorrectPlace();
                    aFactors.splice(nCurrentFactorPair, 1);
                    nProblem++;
                    showProblem();
                    //console.log("NO WINNER");
                }
            } else {
                //console.log("too soon");
                Sound.playCorrectPlace();
                aFactors.splice(nCurrentFactorPair, 1);
                nProblem++;
                showProblem();
            }
        } else {
            //console.log("WRONG");
            nWrong++;

            //console.log("aFactors: " + aFactors.length);
            if (nWrong == 3) {
                Sound.playSecretCodeWrong();
                showProblem();
            } else {
                Sound.playSpinHigh();
            }

        }
    }

    var Bingo = new createjs.Container();
    var bitmap = new createjs.Bitmap(image);
    var nFactor1, nFactor2;
    var aGridNumbers;
    var aBoard;
    var nRows;
    var nColumns;
    var aFactors;
    var aProducts;
    var nProblem;
    var nLevel;
    var nCurrentFactorPair;
    var nCurrentValue;
    var nWrong;
    var sBingo;
    var aBlocks;

    function Main() {
        Bingo.level1x = 30;
        Bingo.level1y = 269;
        Bingo.level2x = 30;
        Bingo.level2y = 349;
        Bingo.level3x = 30;
        Bingo.level3y = 429;
        Bingo.exitx = 71;
        Bingo.exity = 550;
    }

    function initCard() {
        Bingo.removeAllChildren();
        Bingo.addChild(bitmap);
        //console.log("I am an activity card");
        aGridNumbers = [];
        aBoard = [];
        aFactors = [];
        aProducts = [];
        aBlocks = [];
        nRows = size;
        nColumns = size;
        nProblem = 1;
        nWrong = 0;

        // Layer 3
        Bingo.tProblem = new createjs.Text("What's the number?", "60px 'Grilcb'", "#00FFFF");
        Bingo.tProblem.name = "tProblem";
        Bingo.tProblem.textAlign = "center";
        Bingo.tProblem.lineWidth = 1020;
        Bingo.tProblem.parent = Bingo;
        Bingo.tProblem.setTransform(510, 40);
        Bingo.addChild(Bingo.tProblem);
        makeProducts();
        createBoardArray();
        drawBoard();
        showProblem();


    }

    function isSame(n, a) {
        for (var i = 0; i < a.length; i++) {
            ////console.log("isSame: " + i);
            if (n == a[i]) {
                return true;
            }
        }

        return false;
    }

    function createBoardArray() {
        for (var i = 0; i < nRows; i++) {
            aBoard[i] = [];
        }
    }

    function drawBoard() {
        var nSpacing = 4;
        var k = 0;
        for (var i = 0; i < nRows; i++) {
            for (var j = 0; j < nColumns; j++) {
                var boardpiece = makeBoardPieceText();
                if (nRows === 3) {
                    boardpiece.scaleX = 1.0;
                    boardpiece.scaleY = 1.0;
                    boardpiece.x = 354-76 + j * (152 + nSpacing);
                    boardpiece.y = 234-76 + i * (152 + nSpacing);
                } else if (nRows === 4) {
                    boardpiece.scaleX = .9;
                    boardpiece.scaleY = .9;
                    boardpiece.x = 319-76 + j * (140 + nSpacing);
                    boardpiece.y = 214-76 + i * (140 + nSpacing);
                } else {
                    boardpiece.scaleX = .7;
                    boardpiece.scaleY = .7;
                    boardpiece.x = 304-76 + j * (110 + nSpacing);
                    boardpiece.y = 214-76 + i * (110 + nSpacing);
                }


                boardpiece.tNumber.text = (aProducts[k]);
                boardpiece.n = k;
                boardpiece.mouseChildren = false;
                boardpiece.cursor = "pointer";
                boardpiece.addEventListener("click", clickBoardPiece);
                aBoard[i][j] = boardpiece;
                Bingo.addChild(boardpiece);
                boardpiece.setImage(0);
                k++;
            }
        }
    }


    function checkBingo() {
        var b = false;
        if (checkRows() == false) {
            if (checkColumns() == false) {
                if (checkDiagonalLeft() == false) {
                    if (checkDiagonalRight() == false) {
                        return b;
                    } else {
                        b = true;
                        return b;
                    }
                } else {
                    b = true;
                    return b;
                }
            } else {
                b = true;
                return b;
            }
        } else {
            b = true;
            return b;
        }
    }

    function checkRows() {
        var b;
        for (var i = 0; i < nRows; i++) {

            for (var j = 0; j < nColumns; j++) {

                if (aBoard[i][j].currentFrame == 1) {
                    //continue testing next j
                    if (j == nColumns - 1) {
                        //console.log("row " + i + " has bingo");
                        sBingo = "r" + i;
                        b = true;
                        return b;
                    } else {
                        //console.log("continue testing row");
                        b = false;
                    }

                } else {
                    //console.log("stop testing row");
                    b = false;
                    break;
                }
            }
        }
        //console.log("checkRows: " +b);
        return b;
    }

    function checkColumns() {
        var b;
        for (var i = 0; i < nRows; i++) {
            for (var j = 0; j < nColumns; j++) {
                if (aBoard[j][i].currentFrame == 1) {
                    //continue testing next j
                    if (j == nColumns - 1) {
                        //console.log("column " + i + " has bingo");
                        sBingo = "c" + i;
                        b = true;
                        return b;
                    } else {
                        //console.log("continue testing column");
                        b = false;
                    }

                } else {
                    //console.log("stop testing column");
                    b = false;
                    break;
                }
            }
        }
        //console.log("checkColumns: " +b);
        return b;
    }

    function checkDiagonalLeft() {
        var b;
        for (var i = 0; i < nRows; i++) {
            if (aBoard[i][i].currentFrame == 1) {
                //continue testing next j
                if (i == nRows - 1) {
                    //console.log("left diagonal has bingo");
                    sBingo = "top";
                    b = true;
                    return b;
                } else {
                    //console.log("continue testing left diagonal");
                    b = false;
                }
            } else {
                //console.log("stop testing left diagonal");
                b = false;
                break;
            }
        }
        //console.log("checkDiagonalLeft: " +b);
        return b;
    }

    function checkDiagonalRight() {
        var b;
        var j;
        j = nRows - 1;
        console.log(aBoard);
        for (var i = 0; i < nRows; i++) {
            if (aBoard[i][j].currentFrame == 1) {
                //continue testing next j
                if (i == nRows - 1) {
                    //console.log("right diagonal has bingo");
                    sBingo = "bottom";
                    b = true;
                    return b;
                } else {
                    //console.log("continue testing right diagonal");
                    b = false;
                    j--;
                }
            } else {
                //console.log("stop testing right diagonal");
                b = false;
                break;
            }
        }
        //console.log("checkDiagonalRight: " +b);
        return b;
    }

    function determineBingoPosition() {
        var s = sBingo.charAt(0);
        var n;
        if (s == "r") {
            n = sBingo.charAt(1);
            showRowBingo(n);
        } else if (s == "c") {
            n = sBingo.charAt(1);
            showColumnBingo(n);
        } else if (s == "t") {
            showTopBingo();
        } else {
            showBottomBingo();
        }
    }

    function showRowBingo(n) {
        var nFrame;
        for (var i = 0; i < nRows; i++) {
            nFrame = i + 2;
            aBoard[n][i].setImage(nFrame);
        }
    }

    function showColumnBingo(n) {
        var nFrame;
        for (var i = 0; i < nColumns; i++) {
            nFrame = i + 2;
            aBoard[i][n].setImage(nFrame);
        }
    }

    function showTopBingo() {
        var nFrame;
        for (var i = 0; i < nRows; i++) {
            nFrame = i + 2;
            aBoard[i][i].setImage(nFrame);
        }
    }

    function showBottomBingo() {
        var j = 0;
        var n=size+1

        for (var i = nRows - 1; i >= 0; i--) {
            aBoard[i][j].setImage(-1 * i + n);
            j++;
        }
    }

    function turnOffTiles() {
        for (var i = 0; i < nRows; i++) {
            for (var j = 0; j < nColumns; j++) {
                aBoard[i][j].cursor = "default";
                aBoard[i][j].removeEventListener("click", clickBoardPiece);
            }
        }
    }

    function returnToGame(evt) {
        Bingo.tProblem.text = "";
        removeBoardPieces();
        answeredCardCorrectly(nLevel);
    }

    function removeBoardPieces() {
        for (var i = 0; i < nRows; i++) {
            for (var j = 0; j < nColumns; j++) {

                //aBoard[i][j].setImage(1);
                ////console.log("a");
                //aBoard[i][j].tNumber.text = "";
                ////console.log("b");
                Bingo.removeChild(aBoard[i][j]);
                ////console.log("c");
            }
        }
    }


    Bingo.showWin = function () {
        //  BingoNumberNames.complete();
        var bitmap = new createjs.Bitmap(img.next);
        Bingo.disable();
        Bingo.addChild(bitmap);
        bitmap.setTransform(800, 500);
        Sound.playWinningPiece();
        Bingo.disable();
        bitmap.addEventListener('click', function (evt) {
            evt.preventDefault();
            evt.currentTarget.removeAllEventListeners();
            Bingo.callback(Bingo.coins);
        })
    };

    Bingo.enable = function (coins, complete) {
        Bingo.coins = coins;
        Bingo.complete = complete;
        initCard();

    };

    Bingo.disable = function () {
        turnOffTiles();

    };

    Main();

    return Bingo;
}

function setUpGame() {
    stage.removeAllChildren();

    bingoGame =makeCard('Multiplication', makeBingoMultiplication( 10, 5, img.card_bg, 3),
        makeBingoMultiplication( 12, 10, img.card_bg, 4),
        makeBingoMultiplication( 25, 12, img.card_bg, 5))


    stage.addChild(bingoGame);
}

var img;
var stage;
var imagefiles = [

    {src: folder+'bingo-title.png', id: 'title'},
    {src: folder+'card_bg.png', id: "card_bg"},

    {src: folder+'bingo/bingocover-01.png', id: "bingocover1"},
    {src: folder+'bingo/bingocover-02.png', id: "bingocover2"},
    {src: folder+'bingo/bingocover-03.png', id: "bingocover3"},
    {src: folder+'bingo/bingocover-04.png', id: "bingocover4"},
    {src: folder+'bingo/bingocover-05.png', id: "bingocover5"},
    {src: folder+'bingo/bingocover-06.png', id: "bingocover6"},
    {src: folder+'bingo/bingo1.png', id: "bingo1"},
    {src: folder+'bingo/bingo2.png', id: "bingo2"},
    {src: folder+'bingo/bingo3.png', id: "bingo3"},
    {src: folder+'bingo/bingo4.png', id: "bingo4"},
    {src: folder+'bingo/bingo5.png', id: "bingo5"},
    {src: folder+'bingo/bingo6.png', id: "bingo6"},
    {src: folder+'bingo/bingo7.png', id: "bingo7"},
    {src: folder+'coinbutton1.png', id: 'coinButton1'},
    {src: folder+'coinbutton2.png', id: 'coinButton2'},
    {src: folder+'coinbutton3.png', id: 'coinButton3'},

    {src: folder+'coinButton1Large.png', id: 'coinButton1Large'},
    {src: folder+'coinButton2Large.png', id: 'coinButton2Large'},
    {src: folder+'coinButton3Large.png', id: 'coinButton3Large'}
]
var soundfiles = {
    ogg:  [
        {src: 'sound/correctplace.ogg', name: "sndCorrectPlace"},
        {src: "sound/secretcodewrong.ogg", name: "sndSecretCodeWrong"},
        {src: "sound/spinhigh.ogg", name: "sndSpinHigh"},
        {src: 'sound/soundtrack.ogg', name: "sndTrack"},
        {src: 'sound/buttonclick.ogg', name: "sndClick"},
        {src: 'sound/winningpiece.ogg', name: "sndWinningPiece"}
    ],

    mp3: [
        {src: 'sound/buttonclick.mp3', name: "sndClick"},
        {src: 'sound/correctplace.mp3', name: "sndCorrectPlace"},
        {src: "sound/secretcodewrong.mp3", name: "sndSecretCodeWrong"},
        {src: "sound/spinhigh.mp3", name: "sndSpinHigh"},
        {src: 'sound/soundtrack.mp3', name: "sndTrack"},
        {src: 'sound/winningpiece.mp3', name: "sndWinningPiece"}
    ]
};




var BrowserDevice = function () {
    (function (a) {
        (jQuery.browser = jQuery.browser || {}).mobile = /android|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(ad|hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|tablet|treo|up\.(browser|link)|vodafone|wap|webos|windows (ce|phone)|xda|xiino/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))
    })(navigator.userAgent || navigator.vendor || window.opera);
    /**
     *
     * @returns {boolean}
     */
    this.isIOS = function () {
        var iDevices = [
            'iPad Simulator',
            'iPhone Simulator',
            'iPod Simulator',
            'iPad',
            'iPhone',
            'iPod'
        ];

        while (iDevices.length) {
            if (navigator.platform === iDevices.pop()) {
                s_bIsIphone = true;
                return true;
            }
        }
        s_bIsIphone = false;
        return false;
    };
    this.DISABLE_SOUND_MOBILE = false;
    this.s_bMobile = jQuery.browser.mobile;
    if (navigator.userAgent.match(/Windows Phone/i)) {
        this.DISABLE_SOUND_MOBILE = true;
    }
};

(ImageLoader = function (initTitle) {
    var self = this;
    this.finished = false;
    this.initTitle=initTitle;
    this.count=0;
    /**
     *
     * @param imagesfiles
     * @param logo
     * @param img
     */
    this.load = function (imagesfiles, logo, img) {
        self.logo = logo;
        self.img = img;
        var loader = new createjs.LoadQueue(false);
        loader.addEventListener("fileload", handleFileLoad);
        loader.addEventListener("complete", handleComplete);
        loader.loadManifest(imagesfiles);
        this.size=imagesfiles.length;
    };

    /**
     *
     * @param evt
     */
    function handleComplete(evt) {
        evt.preventDefault();
        self.finished = true;
        if (self.logo.finished) {
            initTitle();
        }
    }

    /**
     *
     * @param evt
     */
    function handleFileLoad(evt) {
        evt.preventDefault();
        self.count++;
        if (evt.item.type === "image") {
            self.img[evt.item.id] = evt.result;
        }
        self.logo.
        preloader.update(self.count/self.size);
    }
});

(function () {

    window.ui = window.ui || {};

    var Preloader = function (fill, stroke) {
        this.fillColor = fill;
        this.strokeColor = stroke;
        this.initialize();
    };
    var p = Preloader.prototype = new createjs.Container();

    p.width = 400;
    p.height = 40;
    p.fillColor;
    p.strokeColor;
    p.bar;

    p.Container_initialize = p.initialize;

    p.initialize = function () {
        this.Container_initialize();
        this.drawPreloader();
    };

    p.drawPreloader = function () {
        var outline = new createjs.Shape();
        outline.graphics.beginStroke(this.strokeColor);
        outline.graphics.drawRect(0, 0, this.width, this.height);
        this.bar = new createjs.Shape();
        this.bar.graphics.beginFill(this.fillColor);
        this.bar.graphics.drawRect(0, 0, this.width, this.height);
        this.bar.scaleX = 0;
        this.addChild(this.bar, outline);
    };

    p.update = function (perc) {
        perc = perc > 1 ? 1 : perc;
        this.bar.scaleX = perc;
    };

    window.ui.Preloader = Preloader;

}());
var Logo = function (stage) {
    this.stage = stage;
    var self = this;
    this.finished = false;
    /**
     *
     * @param imageLoader
     */
    this.showLogo = function (imageLoader, callTitle) {
        self.imageLoader = imageLoader;
        var preload = document.getElementById("pre");
        var bit = new createjs.Bitmap(preload);
        self.stage.addChild(bit);
        self.stage.update();
        addPreloader();
        createjs.Tween.get(stage, {useTicks: true}).wait(36).call(logoComplete);

        function logoComplete() {
            self.finished = true;
            if (self.imageLoader.finished) {
                callTitle();
            }
        }
    };

    function addPreloader() {
        self.preloader = new ui.Preloader('#FFCC00', '#000');
        self.preloader.x = (self.stage.canvas.width / 2) - (self.preloader.width / 2);
        self.preloader.y=650;
        self.stage.addChild(self.preloader);
    }
};

var imagePortrait = new Image();
imagePortrait.src = "images/portrait.png";

var Portrait = function () {
    this.canvas = document.getElementById('portrait');
    this.context = this.canvas.getContext('2d');
    var widthToHeight = 768 / 1024;
    var width = window.innerWidth;
    var height = window.innerHeight;
    var newWidthToHeight = width / height;
    if (newWidthToHeight > widthToHeight) {
        width = height * widthToHeight;
    } else {
        height = width / widthToHeight;
    }
    this.canvas.style.width = width + 'px';
    this.canvas.style.height = height + 'px';
};

Portrait.prototype.resize = function () {

    var widthToHeight = 768 / 1024;
    var width = window.innerWidth;
    var height = window.innerHeight;
    var newWidthToHeight = width / height;
    if (newWidthToHeight > widthToHeight) {
        width = height * widthToHeight;
    } else {
        height = width / widthToHeight;
    }
    this.canvas.style.width = width + 'px';
    this.canvas.style.height = height + 'px';
    this.context.drawImage(imagePortrait, 0, 0, 768, 1024);
};
var PreGame = function (portrait, canvas, stage) {
    this.portrait = portrait;
    this.canvas = canvas;
    this.stage = stage;
    /**
     *
     * @param imagesfiles
     * @param soundfiles
     * @param img
     */
    this.start = function (imagesfiles, soundfiles, img, calltitle) {
        var context = this.canvas.getContext('2d');
        //Site lock
        if (document.URL.search("mathplayground.com") >= -1) {
            var imageLoader = new ImageLoader(calltitle);
            var soundLoader = new SoundLoader();
            var screen = new Screen(this);
            var logo = new Logo(this.stage);
            logo.showLogo(imageLoader, calltitle);
            imageLoader.load(imagesfiles, logo, img);
            soundLoader.load(soundfiles);
            screen.setUp();
        } else {

            context.font = 'bold 30pt Arial';
            context.fillStyle = 'red';
            context.fillText("Visit MathPlayground.com for more math games!", 50, 200);
            portrait.context.font = 'bold 20pt Arial';
            portrait.context.fillStyle = 'red';
            portrait.context.fillText("Visit MathPlayground.com  for more math games!", 50, 200);
        }
    }
};

Screen = function (parent) {
    var portrait = parent.portrait;
    var canvas = parent.canvas;
    var stage = parent.stage;
    var width = 1024;
    var height = 768;
    var fps = 24;
    /**
     *
     */
    function fnStartAnimation () {
        createjs.Ticker.setFPS(fps);
        createjs.Ticker.addEventListener("tick", stage);
    }


    /**
     *
     * @param isResp
     * @param respDim
     * @param isScale
     * @param scaleType
     */
    function makeResponsive(isResp, respDim, isScale, scaleType) {
        var lastW, lastH, lastS = 1;
        window.addEventListener('resize', resizeCanvas);
        resizeCanvas();

        /**
         *
         */
        function resizeCanvas() {

            portrait.resize();
            var w = width, h = height;
            var iw = window.innerWidth, ih = window.innerHeight;
            var pRatio = window.devicePixelRatio || 1, xRatio = iw / w, yRatio = ih / h, sRatio = 1;
            if (isResp) {
                if ((respDim === 'width' && lastW === iw) || (respDim === 'height' && lastH === ih)) {
                    sRatio = lastS;
                }
                else if (!isScale) {
                    if (iw < w || ih < h)
                        sRatio = Math.min(xRatio, yRatio);
                }
                else if (scaleType === 1) {
                    sRatio = Math.min(xRatio, yRatio);
                }
                else if (scaleType === 2) {
                    sRatio = Math.max(xRatio, yRatio);
                }
            }
            canvas.width = w * pRatio * sRatio;
            canvas.height = h * pRatio * sRatio;
            canvas.style.width = w * sRatio + 'px';
            canvas.style.height = h * sRatio + 'px';

            stage.scaleX = pRatio * sRatio;
            stage.scaleY = pRatio * sRatio;
            lastW = iw;
            lastH = ih;
            lastS = sRatio;

          //  sketcher.redraw(pRatio, sRatio, canvas.offsetLeft, canvas.offsetTop);//not in original board game added by Jennifer
        }
    }

    /**
     *
     */
    this.setUp = function () {
        stage.removeAllEventListeners();
        if (createjs.Touch.isSupported) {
            createjs.Touch.enable(stage, true, false);
        }

        makeResponsive(true, 'both', true, 1);
        fnStartAnimation();
    };
};

var SoundLoader = function () {

    function soundLoaded() {
        //console.log("soundloaded");
    }

    /**
     *
     * @param soundlist
     */
    this.load = function (soundlist) {
        var i, sound;
        var length = soundlist.mp3.length;
        var browserDevice = new BrowserDevice();
        if (browserDevice.DISABLE_SOUND_MOBILE === false || browserDevice.s_bMobile === false) {
            if (!createjs.Sound.initializeDefaultPlugins()) {
                return;
            }

            if (navigator.userAgent.indexOf("Opera") > 0 || navigator.userAgent.indexOf("OPR") > 0) {
                createjs.Sound.alternateExtensions = ["mp3"];
                createjs.Sound.addEventListener("fileload", soundLoaded);
                for (i = 0; i < length; i++) {
                    sound = soundlist.ogg[i];
                    createjs.Sound.registerSound(sound.src, sound.name);
                }


            } else {
                createjs.Sound.alternateExtensions = ["ogg"];
                createjs.Sound.addEventListener("fileload", soundLoaded);

                for (i = 0; i < length; i++) {
                    sound = soundlist.mp3[i];
                    createjs.Sound.registerSound(sound.src, sound.name);
                }


            }

        }

    }
}
var Sound = {

    playClick: function () {
        createjs.Sound.play('sndClick');
    },

    playCorrectPlace: function () {
        createjs.Sound.play("sndCorrectPlace");
    },

    playSecretCodeWrong: function() {
        createjs.Sound.play("sndSecretCodeWrong");
    },


    playSpinHigh: function () {
        createjs.Sound.play('sndSpinHigh');
    },


    playWinningPiece: function () {
        createjs.Sound.play('sndWinningPiece');
    },

    playTrack: function () {
        //   Sound.track=createjs.Sound.play('sndTrack');
    },

    stop: function () {
        createjs.Sound.stop();

    },

    stopSound: function () {
        createjs.Sound.stop();
    },


}; //this was Sound.as in the original Flash game
var Helper = {

    getRandomNumber: function (n1, n2) {
        if (n2 === 0) {
            return Math.floor((Math.random() * n1));
        }
        else {
            return Math.floor(Math.random() * n1 + n2);
        }
    },

    getRandomObject: function (a) {
        var nRandom = Helper.getRandomNumber(a.length, 0);
        var sRandom = a[nRandom];
        return sRandom;
    },

    shuffle: function (array) {
        var i = 0
            , j = 0
            , temp = null;

        for (i = array.length - 1; i > 0; i -= 1) {
            j = Math.floor(Math.random() * (i + 1));
            temp = array[i];
            array[i] = array[j];
            array[j] = temp
        }
    },

    centerObjectHorizontally: function (objectParentWidth, objectWidth) {
        //console.log(objectParentWidth);
        centerX = (objectParentWidth - objectWidth) / 2;
        return centerX;
    }

};  //this was Helper.as in the original Flash game

var Fraction ={
    units: [ {numerator: 1, denominator: 2},
        {numerator: 1, denominator: 3},
        {numerator: 1, denominator: 4},
        {numerator: 1, denominator: 5},
        {numerator: 1, denominator: 6},
        {numerator: 1, denominator: 8},
        {numerator: 1, denominator: 9},
        {numerator: 1, denominator: 10}, {numerator: 1, denominator: 12}],
    smallFractions: [ {numerator: 1, denominator: 2},
        {numerator: 1, denominator: 3},
        {numerator: 2, denominator: 3},
        {numerator: 1, denominator: 4},
        {numerator: 3, denominator: 4},
        {numerator: 1, denominator: 5},
        {numerator: 2, denominator: 5},
        {numerator: 3, denominator: 5},
        {numerator: 4, denominator: 5},
        {numerator: 1, denominator: 6},
        {numerator: 5, denominator: 6},
        {numerator: 1, denominator: 8},
        {numerator: 1, denominator: 9},
        {numerator: 1, denominator: 10}, {numerator: 1, denominator: 12}],
    allFractions: [ {numerator: 1, denominator: 2},
        {numerator: 1, denominator: 3},
        {numerator: 2, denominator: 3},
        {numerator: 1, denominator: 4},
        {numerator: 3, denominator: 4},
        {numerator: 1, denominator: 5},
        {numerator: 2, denominator: 5},
        {numerator: 3, denominator: 5},
        {numerator: 4, denominator: 5},
        {numerator: 1, denominator: 6},
        {numerator: 5, denominator: 6},
        {numerator: 1, denominator: 8},
        {numerator: 3, denominator: 8},
        {numerator: 5, denominator: 8},
        {numerator: 7, denominator: 8},
        {numerator: 1, denominator: 9},
        {numerator: 2, denominator: 9},
        {numerator: 4, denominator: 9},
        {numerator: 5, denominator: 9},
        {numerator: 7, denominator: 9},
        {numerator: 8, denominator: 9},
        {numerator: 1, denominator: 10},
        {numerator: 3, denominator: 10},
        {numerator: 7, denominator: 10},
        {numerator: 9, denominator: 10},
        {numerator: 1, denominator: 12},
        {numerator: 5, denominator: 12},
        {numerator: 7, denominator: 12},
        {numerator: 11, denominator: 12}],
    nonUnits: [
        {numerator: 2, denominator: 3},
        {numerator: 3, denominator: 4},
        {numerator: 2, denominator: 5},
        {numerator: 3, denominator: 5},
        {numerator: 4, denominator: 5},
        {numerator: 5, denominator: 6},
        {numerator: 3, denominator: 8},
        {numerator: 5, denominator: 8},
        {numerator: 2, denominator: 9},
        {numerator: 4, denominator: 9},
        {numerator: 5, denominator: 9},
        {numerator: 7, denominator: 9},
        {numerator: 8, denominator: 9},
        {numerator: 3, denominator: 10},
        {numerator: 7, denominator: 10},
        {numerator: 9, denominator: 10},
        {numerator: 5, denominator: 12},
        {numerator: 7, denominator: 12},
        {numerator: 11, denominator: 12}],
    getGCF: function (nX, nY) {
        // //console.log (nX+" gcf ny"+nY);
        var _loc5 = nX;
        var _loc4 = nY;
        var _loc1 = [];
        var _loc2 = [];
        //for (n = x; n >= 1; n--)
        for (var n = nX; n >= 1; n--) {
            if (_loc5 % n === 0) {
                _loc1.push(n);
            } // end if
        } // end of for
        for (var m = nY; m >= 1; m--) {
            if (_loc4 % m === 0) {
                _loc2.push(m);
            } // end if
        } // end of for
        _loc1.reverse();
        _loc2.reverse();
        for (var i = 0; i < _loc1.length; i++) {
            for (var j = 0; j < _loc2.length; j++) {
                if (_loc1[i] === _loc2[j]) {
                    var _loc3 = _loc1[i];
                } // end if
            } // end of for
        } // end of for
        return (_loc3);
    },

    getLCM: function (a, b) {
        return (a * b / Fraction.getGCF(a, b));
    },

    reduceFraction: function (n,d) {
        if (d===1){
            return [n,d];
        }else {
            var gcf = Fraction.getGCF(n, d);
            return [n / gcf, d / gcf];
        }
    },

    addFraction: function (n1, d1, n2, d2) {
        //console.log(n1+"/"+d1+',  '+n2+'/'+d2);
        if (d1===d2){
            return [n1+n2,d1];
        }else if(n1===0){
            return [n2,d2];
        }else if (n2===0){
            return [n1,d1];
        }else {
            return Fraction.reduceFraction(n1 * d2 + n2 * d1, d1 * d2);
        }
    },
    addFractionNumber: function (n1, d1, n2, d2) {
        var sum=Fraction.addFraction(n1,d1,n2,d2);
        return sum[0]/sum[1];
    },

    subtractFraction: function (n1, d1, n2, d2) {
        //    console.log(n1+"/"+d1+',  '+n2+'/'+d2);
        if (d1 === d2) {
            return [n1 - n2, d1];
        } else if (n1 === 0) {
            return [-n2, d2];
        } else if (n2 === 0) {
            return [n1, d1];
        } else {
            return Fraction.reduceFraction(n1 * d2 - n2 * d1, d1 * d2);
        }
    },
    equalFractios: function (n1, d1, n2, d2) {
        var f1=Fraction.reduceFraction(n1,d1);
        var f2=Fraction.reduceFraction(n2,d2);
        return f1[0]===f2[0]&&f1[1]===f2[1];
    },

    displayFractionNumberLine: function (numerator1, denominator1, font, font2, color, width, height) {
        var number;
        var numerator, shape, denominator, t;
        var fraction = new createjs.Container();
        // Layer 1
        if (denominator1 === 1) {
            number = numerator1;
            t = new createjs.Text(number, font2, color);
            t.name = 't';
            t.textAlign = 'center';
            t.textBaseline = 'top';
            t.setTransform(0,5);
            fraction.addChild(t);

        }
        else if (numerator1 % denominator1 === 0) {
            number = numerator1 / denominator1;
            t = new createjs.Text(number, font2, color);
            t.name = 't';
            t.textAlign = 'center';
            t.textBaseline = 'top';
            t.setTransform(0,5);
            fraction.addChild(t);
        }
        else {
            numerator = new createjs.Text(numerator1, font, color);
            numerator.name = 'numerator';
            numerator.textAlign = 'center';
            numerator.textBaseline = 'top';
            numerator.setTransform(0, 6);

            denominator = new createjs.Text(denominator1, font, color);
            denominator.name = 'denominator ';
            denominator.textAlign = 'center';
            denominator.setTransform(0, height + numerator.getMeasuredHeight() + 5);

            shape = new createjs.Shape();
            shape.graphics.beginFill().beginStroke(color).setStrokeStyle(3, 1, 3, true).moveTo(-.5 * width, 0).lineTo(.5 * width, 0);
            shape.setTransform(0, height + numerator.getMeasuredHeight());
            fraction.addChild(numerator);
            fraction.addChild(denominator);
            fraction.addChild(shape);

        }

        fraction.numerator=numerator1;
        fraction.denometer=denominator1;
        return fraction;
    },

    displayFraction: function   (numerator1, denominator1, font, font2, color, width) {
        var number;
        var numerator, shape, denominator, t;
        var fraction = new createjs.Container();
        // Layer 1
        if (numerator1<denominator1) {
            fraction.numerator = new createjs.Text(numerator1, font, color);
            fraction.numerator.name = "numerator";
            fraction.numerator.textAlign = "center";
            fraction.numerator.textBaseline = "botton";
            fraction.numerator.setTransform(0, -7);

            fraction.denominator = new createjs.Text(denominator1, font, color);
            fraction.denominator.name = "denominator ";
            fraction.denominator.textAlign = "center";
            fraction.denominator.setTransform(0, 1);

            shape = new createjs.Shape();
            shape.graphics.beginFill().beginStroke(color).setStrokeStyle(2, 1, 2, true).moveTo(-.5 * width, -2).lineTo(.5 * width, -2);
            fraction.addChild(fraction.numerator);
            fraction.addChild(fraction.denominator);
            fraction.addChild(shape);
        }
        else if (numerator1% denominator1 ===0){
            number=numerator1/denominator1;
            t = new createjs.Text(number, font2, color);
            t.name = "t";
            t.textAlign = "center";
            t.textBaseline = "middle";
            fraction.addChild(t);
        } else {
            numerator = new createjs.Text(numerator1, font, color);
            numerator.name = "numerator";
            numerator.textAlign = "center";
            numerator.textBaseline = "botton";
            numerator.setTransform(0, -7);

            denominator = new createjs.Text(denominator1, font, color);
            denominator.name = "denominator ";
            denominator.textAlign = "center";
            denominator.setTransform(0, 1);

            shape = new createjs.Shape();
            shape.graphics.beginFill().beginStroke(color).setStrokeStyle(2, 1, 2, true).moveTo(-.5 * width, -2).lineTo(.5 * width, -2);
            fraction.addChild(numerator);
            fraction.addChild(denominator);
            fraction.addChild(shape);
        }
        fraction.isSame=function (n,d) {
            return n===numerator1&& d===denominator1;
        }
        return fraction;
    },

    displaymixedNumber: function   (numerator1, denominator1, number, font, font2, color, width) {
        //var number;
        var numerator, shape, denominator, t;
        var fraction = new createjs.Container();
        // Layer 1
        t = new createjs.Text(number, font2, color);
        t.name = "t";
        t.textAlign = "center";
        t.textBaseline = "middle";
        t.x=-50;
        fraction.addChild(t);
        numerator = new createjs.Text(numerator1, font, color);
        numerator.name = "numerator";
        numerator.textAlign = "center";
        numerator.textBaseline = "botton";
        numerator.setTransform(10, -7);

        denominator = new createjs.Text(denominator1, font, color);
        denominator.name = "denominator ";
        denominator.textAlign = "center";
        denominator.setTransform(10, 1);

        shape = new createjs.Shape();
        shape.graphics.beginFill().beginStroke(color).setStrokeStyle(2, 1, 2, true).moveTo(-.5 * width, -2).lineTo(.5 * width, -2);
        shape.x=10
        fraction.addChild(numerator);
        fraction.addChild(denominator);
        fraction.addChild(shape);

        fraction.isSame=function (m, n,d) {
            return m===number&& n===numerator1&& d===denominator1;
        }
        return fraction;
    },


    displayUnknownFraction: function   (x,y) {
        var number;
        var numerator, shape, denominator, t;
        var fraction = new createjs.Container();
        fraction.x=x;
        fraction.y=y;
        fraction.numerator = new NumberLabel(50,50);
        fraction.numerator.setTransform(-26, -52);

        fraction.denominator = new NumberLabel(50,50);
        fraction.denominator.setTransform(-26, 8);
        fraction.width=52;
        shape = new createjs.Shape();
        shape.graphics.beginFill().beginStroke("#000").setStrokeStyle(3, 1, 3, true).moveTo(-.5 * fraction.width, 2.5).lineTo(
            .5 * fraction.width, 2.5);
        fraction.addChild(fraction.numerator);
        fraction.addChild(fraction.denominator);
        fraction.addChild(shape);
        fraction.set=function (n,d){
            fraction.numerator.t.text=n;
            fraction.denominator.t.text=d;
        };

        //console.log("The fraction is");
        //console.log(fraction);
        return fraction;
    }
};

var Point = function (x, y) {
    this.x = x;
    this.y = y;
};


function shuffle(array) {
    var i, j, temp;

    for (i = array.length - 1; i > 0; i -= 1) {
        j = Math.floor(Math.random() * (i + 1));
        temp = array[i];
        array[i] = array[j];
        array[j] = temp;
    }
}

function TitleScreen  ( title,  homefunctipomn) {

    var self = new createjs.Bitmap(title);

    function onStartButton() {
        Sound.playTrack()
        homefunctipomn();
    }

    self.addEventListener('click', onStartButton);
    return self;
}

function makeCard(name, level1, level2, level3) { //levels are containers with all the info to make a level 1, 2, or 3 puzzle
    var Card=new createjs.Container();
    // Layer 7
    Card.title = new createjs.Text(name, "72px 'Grilcb'", "#FFFFFF");
    Card.title.textAlign = "center";
    Card.title.lineHeight = 101;
    Card.title.lineWidth = 1020;
    Card.title.parent = Card;
    Card.title.setTransform(511.8, 90);
    Card.title.shadow = new createjs.Shadow("rgba(0,0,0,1)", 3, 3, 4);

    Card.text = new createjs.Text("Level 3", "60px 'Grilcb'", "#FFFFFF");
    Card.text.textAlign = "center";
    Card.text.lineHeight = 101;
    Card.text.lineWidth = 238;
    Card.text.parent = Card;
    Card.text.setTransform(812.7, 470);
    Card.text.shadow = new createjs.Shadow("rgba(0,0,0,1)", 3, 3, 4);

    Card.text_1 = new createjs.Text("Level 2", "60px 'Grilcb'", "#FFFFFF");
    Card.text_1.textAlign = "center";
    Card.text_1.lineHeight = 101;
    Card.text_1.lineWidth = 238;
    Card.text_1.parent = Card;
    Card.text_1.setTransform(510.8, 470);
    Card.text_1.shadow = new createjs.Shadow("rgba(0,0,0,1)", 3, 3, 4);

    Card.text_2 = new createjs.Text("Level 1", "60px 'Grilcb'", "#FFFFFF");
    Card.text_2.textAlign = "center";
    Card.text_2.lineHeight = 101;
    Card.text_2.lineWidth = 238;
    Card.text_2.parent = Card;
    Card.text_2.setTransform(212.9, 470);
    Card.text_2.shadow = new createjs.Shadow("rgba(0,0,0,1)", 3, 3, 4);


    Card.m3 = new createjs.Bitmap(img.coinButton3Large);
    Card.m3.parent = Card;
    Card.m2 = new createjs.Bitmap(img.coinButton2Large);
    Card.m2.parent = Card;
    Card.m1 = new createjs.Bitmap(img.coinButton1Large);
    Card.m1.parent = Card;

    // Layer 1
    Card.background = new createjs.Bitmap(img.card_bg);
    Card.background.parent = Card;

    Card.enable=function(){
        Card.addChild(Card.background);
        Card.addChild(Card.m1);
        Card.addChild(Card.m2);
        Card.addChild(Card.m3);
        Card.m1.image=img.coinButton1Large;
        Card.m2.image=img.coinButton2Large;
        Card.m3.image=img.coinButton3Large;
        Card.m3.setTransform(689, 267);
        Card.m2.setTransform(389, 267);
        Card.m1.setTransform(89, 267);
        Card.addChild(Card.text);
        Card.addChild(Card.text_1);
        Card.addChild(Card.text_2);
        Card.addChild(Card.title);

        Card.m1.cursor = "pointer";
        Card.m1.addEventListener("click", chooseLevel1);
        Card.m2.cursor = "pointer";
        Card.m2.addEventListener("click", chooseLevel2);
        Card.m3.cursor = "pointer";
        Card.m3.addEventListener("click", chooseLevel3);
    };

    function complete() {
        Card.m1.removeAllEventListeners();
        Card.m2.removeAllEventListeners();
        Card.m3.removeAllEventListeners();
    }
    function addLevelButtons() {
        Card.addChild(Card.m1);
        Card.addChild(Card.m2);
        Card.addChild(Card.m3);
        Card.addChild(Card.mExit);

        Card.m1.image=img.coinButton1;
        Card.m2.image=img.coinButton2;
        Card.m3.image=img.coinButton3;
        Card.m3.setTransform(Card.current.level3x, Card.current.level3y, 1, 1);
        Card.m2.setTransform(Card.current.level2x, Card.current.level2y, 1, 1);
        Card.m1.setTransform(Card.current.level1x, Card.current.level1y, 1, 1);
    }

    function chooseLevel1(evt) {
        Sound.playClick();
        if ("current" in Card){
            Card.current.disable();
        }
        Card.removeAllChildren();

        Card.addChild(level1);
        level1.enable( 1, complete);
        Card.current=level1;
        addLevelButtons();
    }

    function chooseLevel2(evt) {
        Sound.playClick();
        if ("current" in Card){
            Card.current.disable();
        }
        Card.removeAllChildren ();

        Card.addChild(level2);
        level2.enable(2, complete);
        Card.current=level2;
        addLevelButtons();
    }

    function chooseLevel3(evt) {
        Sound.playClick();
        if ("current" in Card){
            Card.current.disable();
        }
        Card.removeAllChildren ();
        Card.current=level3;
        Card.addChild(level3);
        level3.enable( 3, complete);
        addLevelButtons();
    }
    Card.enable();
    return Card;
}
function makeBoardPieceText() {
    var BoardPiece = new createjs.Container();
    // Layer 2
    BoardPiece.tNumber = new createjs.Text("000", "78px 'Grilcb'", "#FFFFFF");
    BoardPiece.tNumber.name = "tNumber";
    BoardPiece.tNumber.textAlign = "center";
    BoardPiece.tNumber.textBaseline = "middle";
    BoardPiece.tNumber.lineHeight = 30;
    BoardPiece.tNumber.lineWidth = 46;
    BoardPiece.tNumber.parent = BoardPiece;
    BoardPiece.tNumber.setTransform(76, 82);

    BoardPiece.instance = new createjs.Bitmap(img.bingo1);
    BoardPiece.instance.setTransform(0, 0);
    BoardPiece.pict = new createjs.Bitmap(img['bingocover' + Math.ceil(Math.random()*bingocover)]);
    BoardPiece.pict.setTransform(0, 0);
    BoardPiece.addChild(BoardPiece.instance);
    BoardPiece.addChild(BoardPiece.tNumber);
    BoardPiece.addChild(BoardPiece.pict)
    BoardPiece.currentFrame = 0;
    BoardPiece.setImage = function (n) {
        BoardPiece.currentFrame = n;
        BoardPiece.tNumber.visible = (n === 0);
        if (n===1){
            BoardPiece.pict.visible=true;
            BoardPiece.instance.image = img['bingo1'];
        }else
        {
            BoardPiece.pict.visible=false;
            BoardPiece.instance.image = img['bingo' + (n + 1)];
        }
    };
    return BoardPiece;
}

function makeBoardPieceShape() {
    var BoardPiece = new createjs.Container();
    // Layer 2
    BoardPiece.tNumber = new createjs.Shape();
    BoardPiece.tNumber.name = "tNumber";
    BoardPiece.tNumber.parent = BoardPiece;
    BoardPiece.tNumber.setTransform(76, 82);

    BoardPiece.instance = new createjs.Bitmap(img.bingo1);
    BoardPiece.instance.setTransform(0, 0);
    BoardPiece.addChild(BoardPiece.instance);
    BoardPiece.addChild(BoardPiece.tNumber);

    BoardPiece.currentFrame = 0;
    BoardPiece.setImage = function (n) {
        BoardPiece.currentFrame = n;
        BoardPiece.tNumber.visible = (n === 0);
        BoardPiece.instance.image = img['bingo' + (n + 1)];
    };
    return BoardPiece;
}


function makeBoardPiecemixednumber(m, n,d) {
    var BoardPiece = new createjs.Container();
    // Layer 2
    BoardPiece.tNumber =  Fraction.displaymixedNumber(n,d, m, '75px Arial', 'bold 60px Arial', "#000", 60);
    BoardPiece.tNumber.name = "tNumber";
    BoardPiece.tNumber.parent = BoardPiece;
    BoardPiece.tNumber.setTransform(76, 82);

    BoardPiece.instance = new createjs.Bitmap(img.bingo1);
    BoardPiece.instance.setTransform(0, 0);
    BoardPiece.pict = new createjs.Bitmap(img['bingocover' + Math.ceil(Math.random()*bingocover)]);
    BoardPiece.pict.setTransform(0, 0);
    BoardPiece.addChild(BoardPiece.instance);
    BoardPiece.addChild(BoardPiece.tNumber);

    BoardPiece.addChild(BoardPiece.pict);
    BoardPiece.currentFrame = 0;
    BoardPiece.setImage = function (n) {
        BoardPiece.currentFrame = n;
        BoardPiece.tNumber.visible = (n === 0);
        if (n===1){
            BoardPiece.pict.visible=true;
            BoardPiece.instance.image = img['bingo1'];
        }else
        {
            BoardPiece.pict.visible=false;
            BoardPiece.instance.image = img['bingo' + (n + 1)];
        }
    };
    return BoardPiece;
}

function makeBoardPieceFraction(n,d) {
    var BoardPiece = new createjs.Container();
    // Layer 2
    BoardPiece.tNumber =  Fraction.displayFraction(n,d, '75px Arial', 'bold 40px Arial', "#000", 80);
    BoardPiece.tNumber.name = "tNumber";
    BoardPiece.tNumber.parent = BoardPiece;
    BoardPiece.tNumber.setTransform(76, 82);

    BoardPiece.instance = new createjs.Bitmap(img.bingo1);
    BoardPiece.instance.setTransform(0, 0);
    BoardPiece.pict = new createjs.Bitmap(img['bingocover' + Math.ceil(Math.random()*bingocover)]);
    BoardPiece.pict.setTransform(0, 0);
    BoardPiece.addChild(BoardPiece.instance);
    BoardPiece.addChild(BoardPiece.tNumber);
    BoardPiece.addChild(BoardPiece.pict);
    BoardPiece.currentFrame = 0;
    BoardPiece.setImage = function (n) {
        BoardPiece.currentFrame = n;
        BoardPiece.tNumber.visible = (n === 0);
        if (n===1){
            BoardPiece.pict.visible=true;
            BoardPiece.instance.image = img['bingo1'];
        }else
        {
            BoardPiece.pict.visible=false;
            BoardPiece.instance.image = img['bingo' + (n + 1)];
        }
    };
    return BoardPiece;
}
(function () { //nameless function just runs

        var bingoGame;
        var portrait;
        var canvas;
        var title;
        var playtrack = true;
        var blockPoint=true;

        function initPreGame() {
            img = [];
            portrait = new Portrait();
            canvas = document.getElementById('canvas');
            stage = new createjs.Stage(canvas);
            if (extraimages.length>0){
                imagefiles=imagefiles.concat(extraimages);
            }
            var preGame = new PreGame(portrait, canvas, stage);
            preGame.start(imagefiles, soundfiles, img, initTitle);

        }

        function initTitle() {
            title = new TitleScreen( img.title, setUpGame);
            stage.removeAllChildren();
            stage.addChild(title);
        }

        //setTimeout is at the end of a function without a name
        //code inside nameless function runs automatically
        //pause 200 ms for iOS
        setTimeout(function () {

            initPreGame();
        }, 200);
    }

)();