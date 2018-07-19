var MyApp = {
    list : [],
    addDragData : function(dragData, parentIndex) {
        myArray = MyApp.list[parentIndex-1].tasks;
        myArray[myArray.length] = {
            name : dragData[0].name,
            desc : dragData[0].desc,
            type : 'task',
            parent : 'board_' + parentIndex
        } 
    },
    allowDrop : function (ev) {
        ev.preventDefault();
    },
    drag : function(ev) {
        item = ev.target;
        ev.dataTransfer.setData("text", '');
    },
    drop : function(ev) {
        ev.preventDefault();
        ev.target.appendChild(item);
        var newBoardIndex = (ev.target.parentNode.id).match(/\d+/)[0];
        var deleteTaskIndex = item.getAttribute('data-index');
        var deleteBoardIndex = item.getAttribute('data-board-index');
        dragData = this.list[deleteBoardIndex].tasks.slice(deleteTaskIndex, deleteTaskIndex + 1);
        this.list[deleteBoardIndex].tasks.splice(deleteTaskIndex, 1);
        this.addDragData(dragData, newBoardIndex);
        this.saveData();
    }
}

