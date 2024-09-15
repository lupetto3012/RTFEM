document.onkeydown = function (evt) {
    if (evt.ctrlKey && evt.key == 'a') {
        emitter.emit('keypress-ctrl-a', evt);
    }

    if (evt.ctrlKey && evt.key == 'f') {
        emitter.emit('keypress-ctrl-f', evt);
    }

    if (evt.ctrlKey && evt.key == 's') {
        emitter.emit('keypress-ctrl-s', evt);
    }

    if (evt.key == 'ArrowUp') {
        emitter.emit('keypress-arrow-up', evt);
    }
    if (evt.key == 'ArrowDown') {
        emitter.emit('keypress-arrow-down', evt);
    }
    if (evt.key == 'ArrowLeft') {
        emitter.emit('keypress-arrow-left', evt);
    }
    if (evt.key == 'ArrowRight') {
        emitter.emit('keypress-arrow-right', evt);
    }
};