window.onload = function() {
    // this function is use to draw in the html file
    
    var canvasWidth = 900;
    var canvasHeight = 600;
    var blockSize = 30;
    var ctx;
    var delay = 100;
    var snakee;

    init();

    function init() {
        var canvas = document.getElementById("canva");
        canvas.style.border = "1px solid black";
        ctx = canvas.getContext('2d');
        snakee = new Snake([[6,4], [5,4], [4, 4]])
        refeshCanvas();
    }
    
    function refeshCanvas() {
        ctx.clearRect(0, 0, canvasWidth, canvasHeight);
        snakee.draw();
        setTimeout(refeshCanvas, delay);
    }

    function drawBlock(ctx, position) {
        var x = position[0] * blockSize;
        var y = position[1] * blockSize;
        ctx.fillRect(x, y, blockSize, blockSize);   
    }

    function Snake(body) {
        this.body = body;
        this.draw = function() {
            ctx.save();
            ctx.fillStyle = "#ff0000";
            for (var i = 0; i < this.body.length; i++) {
                drawBlock(ctx, this.body[i]);
            }
            ctx.restore();
        }
    }
}