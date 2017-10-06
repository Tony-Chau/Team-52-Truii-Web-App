var size = "<?php echo $size; ?>";
//var XY_values = array();
var x;
var y;
function X_column(num) {
    if (x != null){
        $("table>thead:first-child>tr:first-child>th:nth-child(" + x + ")").css("background-color", "white");
    }

    var old_x = x;
    x = document.getElementById("X_column_selected"+num).value;
    if (x == 0){
        $("table>thead:first-child>tr:first-child>th:nth-child(" + old_x + ")").css("background-color", "white");
    }
    else if (x > 0){
        if (x == y){
            y = 0;

            document.getElementById("Y_column_selected"+num).value = y;
        }
        $("table>thead:first-child>tr:first-child>th:nth-child(" + x + ")").css("background-color", "rgb(252, 103, 25)");
    }
}


function Y_column() {
    if (y != null){
        $("table>thead:first-child>tr:first-child>th:nth-child(" + y + ")").css("background-color", "white");
    }

    old_y = y;
    y = document.getElementById("Y_column_selected"+num).value;
    if (y == 0){
        $("table>thead:first-child>tr:first-child>th:nth-child(" + old_y + ")").css("background-color", "white");
    }
    else if (y > 0){
        if (y == x){
            x = 0;
            document.getElementById("X_column_selected"+num).value = x;
        }
        $("table>thead:first-child>tr:first-child>th:nth-child(" + y + ")").css("background-color", "rgb(31,194,222)");
    }
}

function chooseFields(Primary, Secondary){

  var xy = '';
  var i = 1;
  xy += '<div class="input-group">';
  xy += '<select name="'+Primary+'_column_selected'+i+'" id="xy_selected_'+i+'" onchange="'+Primary+'_column('+i+')" class="form-control">';
  xy += '<option value=0>Select '+Primary+' Value</option>';
  xy += '<?php echo $output; ?>';
  xy += '</select></div><br/>';

  var number = '#Column' + i;
  for (i = 2; i < size; i+=1){
      xy += '<div class="input-group">';
      xy += '<select name="'+Secondary+'_column_selected'+i+'" id="xy_selected_'+i+'" onchange=\"'+Secondary+'_column('+i+')" class="form-control">';
      xy += '<option value=0>Select '+Secondary+' Value</option>';
      xy += '<?php echo $output; ?>';
      xy += '</select><span class="input-group-btn">';
      xy += '<button class="btn btn-default" type="button"> X </button>';
      xy += '</span></div><br/>';
  }
  $('#XYSelector').append(xy);

}
function deleteField(column){
  document.getElementById("textinput" + column).required = false;
  document.getElementById("textinput" + column).value = '';
}


function updateXY(num, val){
  for (var i = 1; i < size; i += 1){
    if ( i != num ){
      var select=document.getElementById('xy_selected'+i);
      for (var j = 1; i < select.length; i+=1) {
        if (select.options[i].value == val) {
          select.option[i].disabled = true;
        }
      }
    }
  }

  function renewXY(){
    //for (var i = 1; i < size){}
  }
}
