var drake = window.dragula();

function initDragula() {
  var containers = [document.getElementById('contenders')];
  var endorsed_array = document.getElementsByClassName('td endorsed-col container enabled');
  var recommended_array = document.getElementsByClassName('td recommended-col container enabled');

  for(var i=0; i<endorsed_array.length; i++) {containers.push(endorsed_array[i]);}
  for(var i=0; i<recommended_array.length; i++) {containers.push(recommended_array[i]);}
  // update UI from boards object
  updateUI(contenders_data_json, whiteboard_data_json);

  drake.destroy();
  drake = dragula(containers, {
    moves: function (el, source, handle, sibling) {
      if(el.classList.contains("header-style"))
        return false;
      else
        return true;
    }
  })
  .on("drag", function(el, source) {
    // el.classList.add("is-moving");
  })
  .on("dragend", function(el) {
    // el.classList.remove("is-moving");
  })
  .on("drop", function(el, target, source, sibling) {
    // el.classList.remove("is-moving");
    updateWhiteboard(el.id, source.id, target.id);
  });
}

function updateUI(contenders, whiteboard){
  for(contender of contenders) {
    var i = whiteboard.findIndex(x => x.card_id == contender.id);;
    if(i !== -1) { // based on whiteboard data, check if contender needs to be transferred
      var board_id = whiteboard[i].board_id;
      if(document.getElementById(board_id)) { // if yes, check if target container is displayed
        transferCard(contender.id, "contenders", board_id); // 
      }
      else {
        // hide contender (using jquery)
        $("#"+contender.id).toggle();
      }
    }
    else {
      transferCard(contender.id, "contenders", "contenders");
    };
  }
}

function transferCard(cardId, containerIdFrom, containerIdTo) {
  var card = document.getElementById(cardId);
  var containerFrom = document.getElementById(containerIdFrom);
  var containerTo = document.getElementById(containerIdTo);

  containerTo.appendChild(containerFrom.removeChild(card));
  return;
}

function updateWhiteboard(card_id, from_board_id, to_board_id) {
  $.ajax({
    type: "POST",
    url: "<?php echo base_url()?>whiteboard/update",
    data: {
      card_id: card_id,
      from_board_id: from_board_id,
      to_board_id: to_board_id
    },
    dataType: "json",
    success: function(result, status, xhr) {

    }
  });
}