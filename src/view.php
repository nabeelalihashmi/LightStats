<div id='ls__container'>
    <div id="ls__header">
        <span> LightStats Debug </span>
        <div class="ls__controls">
            <span title="Toggle Types" class="ls__control" id="ls__types__toggle"> ⚙ </span>
            <span title="Minimize" class="ls__control" id="ls__control__toggle"> ☰ </span>
            <span title="FullScreen" class="ls__control" id="ls__control__max"> ☐ </span>
            <span title="Close" class="ls__control" id="ls__control__close"> &times; </span>
        </div>
    </div>
    <div class="ls__separator"></div>

    <div id="ls__body">
        <table id="ls__table">
            <?php echo $html ?>
        </table>
    </div>


    <div id="ls__footer">
        <a href="https://iconiccodes.com">Written By Nabeel Ali | https://iconiccodes.com</a>
    </div>
</div>

<style>
    .ls__type__label {
        background-color: #22222288;
        color: white;
        padding: 4px;
        font-size: 10pt;
        margin-top: 3px;
        font-family: monospace;
    }

    #ls__container {
        display: flex;
        flex-direction: column;
        font-size: 10pt;
        font-family: sans-serif;
        position: fixed;
        bottom: 10px;
        right: 10px;
        border-radius: 8px;
        width: 400px;
        height: 450px;
        /* height: auto; */
        background-color: #39393999;
        backdrop-filter: blur(4px);
        padding: 10px;
        box-shadow: 0 0 10px #000;
        z-index: 99999;
        min-height: 60px;

    }

    .ls__control {
        margin-left: 10px;
        cursor: pointer;
    }

    #ls__control__close {
        font-size: 18px;
    }

    .ls__controls {
        margin-left: auto;
    }

    #ls__body {
        flex: 1;
        overflow: auto;
        background-color: #fff;
    }

    .ls__separator {
        height: 1px;
        background-color: #ccc;
        margin: 10px 0;
    }



    #ls__header {
        width: 100%;
        display: flex;
        text-shadow: 0 0 10px #000;
        color: #fff;
        align-items: center;
        cursor: nwse-resize;

    }

    #ls__footer {
        margin-top: 10px;
        text-align: center;
    }

    #ls__footer a {
        color: #fff;
    }

    #ls__container table {
        border-collapse: collapse;
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        font-family: sans-serif;
        background-color: #fff;
        margin-bottom: 8px;
    }

    #ls__table td {
        padding: 3px 12px;
        border: 1px solid #ccc;
        cursor: pointer;

        vertical-align: top;
    }

    #ls__table td:hover {
        background-color: #888;
    }
</style>

<script>
    var ls__container = document.getElementById('ls__container');
    var ls__control__toggle = document.getElementById('ls__control__toggle');
    var ls__control__max = document.getElementById('ls__control__max');
    var ls__control__close = document.getElementById('ls__control__close');
    var ls__body = document.getElementById('ls__body');
    var ls__table = document.getElementById('ls__table');

    var ls__types__label = document.getElementById('ls__types__toggle');
    // toggle .ls__type__label display
    ls__types__label.addEventListener('click', function() {
        var ls__types__label = document.getElementsByClassName('ls__type__label');
        for (var i = 0; i < ls__types__label.length; i++) {
            ls__types__label[i].style.display = (ls__types__label[i].style.display == 'none') ? 'block' : 'none';
        }
    });
    



    ls__control__toggle.addEventListener('click', function() {
        ls__container.style.bottom = "10px;"
        ls__container.style.right = "10px;"
        

        if (document.fullscreenElement) {
            document.exitFullscreen();
        } 

        if (ls__body.style.display == 'none') {
            ls__body.style.display = 'block';
        } else {
            ls__body.style.display = 'none';    
            ls__container.style.height = 'auto';
        }
    });

    ls__control__max.addEventListener('click', function() {
        ls__body.style.display = 'block';
        if (ls__container.requestFullscreen) {
            if (document.fullscreenElement) {
                document.exitFullscreen();
            } else {
                ls__container.requestFullscreen();
            }
        } else if (ls__container.webkitRequestFullscreen) {
            if (document.webkitFullscreenElement) {
                document.webkitExitFullscreen();
            } else {
                ls__container.webkitRequestFullscreen();
            }
        } else if (ls__container.mozRequestFullScreen) {
            if (document.mozFullScreenElement) {
                document.mozCancelFullScreen();
            } else {
                ls__container.mozRequestFullScreen();
            }
        } else if (ls__container.msRequestFullscreen) {
            if (document.msFullscreenElement) {
                document.msExitFullscreen();
            } else {
                ls__container.msRequestFullscreen();
            }
        }

    });


    ls__control__close.addEventListener('click', function() {
        ls__container.remove();
    });


    var ls__container_resize = document.getElementById('ls__header');
    var ls__container_resize_x = 0;
    var ls__container_resize_y = 0;
    var ls__container_resize_width = 0;
    var ls__container_resize_height = 0;

    ls__container_resize.addEventListener('mousedown', function(e) {
        ls__container_resize_x = e.clientX;
        ls__container_resize_y = e.clientY;
        ls__container_resize_width = ls__container.offsetWidth;
        ls__container_resize_height = ls__container.offsetHeight;
    });
    
    document.addEventListener('mousemove', function(e) {
        if (ls__container_resize_x && ls__container_resize_y) {
            var x = e.clientX - ls__container_resize_x;
            var y = e.clientY - ls__container_resize_y;
            x = x * -1;
            y = y * -1;
            ls__container.style.width = ls__container_resize_width + x + 'px';
            ls__container.style.height = ls__container_resize_height + y + 'px';
            ls__body.style.display = 'block';
        }
    });

    document.addEventListener('mouseup', function(e) {
        ls__container_resize_x = 0;
        ls__container_resize_y = 0;
        ls__container_resize_width = 0;
        ls__container_resize_height = 0;
    });

    ls__table.addEventListener('dblclick', function(e) {
        var text = e.target.innerText;
        navigator.clipboard.writeText(text);
        console.log('Copied: ', text);
        var popup = document.createElement('div');
        popup.style.position = 'absolute';
        popup.style.top = e.clientY + 'px';
        popup.style.left = e.clientX + 'px';
        popup.style.backgroundColor = '#fff';
        popup.style.padding = '5px';
        popup.style.borderRadius = '5px';
        popup.style.fontSize = '10pt';
        popup.style.fontFamily = 'sans-serif';
        popup.style.color = '#fff';
        popup.style.textAlign = 'center';
        popup.style.backgroundColor = '#000000aa';
        popup.style.border = '1px solid #000';
        popup.innerText = 'Copied';
        popup.style.zIndex = 199999;
        document.body.appendChild(popup);

        setTimeout(function() {
            document.body.removeChild(popup);
        }, 1000);
    });

</script>