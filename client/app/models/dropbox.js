function DropBoxModel(dbElement, dragEnterHandler, dragLeaveHandler, dropHandler){

    dbElement.addEventListener('dragenter', function(e){

        e.preventDefault();

        e.dataTransfer.dropEffect = 'copy';
        this.classList.add('hover');

        if(dragEnterHandler != null) dragEnterHandler(e);

    }, false);

    dbElement.addEventListener('dragover', function(e){

        e.preventDefault();

        e.dataTransfer.dropEffect = 'copy';
        return false;

    }, false);

    dbElement.addEventListener('dragleave', function(e){

        e.preventDefault();

        this.classList.remove('hover');

        if(dragLeaveHandler != null) dragLeaveHandler(e);

    }, false);

    dbElement.addEventListener('drop', function(e){

        e.preventDefault();

        this.classList.remove('hover');

        if(dropHandler != null) dropHandler(e);

    }, false);
}