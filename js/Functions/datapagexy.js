function X_column(index) {
  for (var i = 0; i < size; i += 1){
    $("table>thead>tr>th:nth-child(" + i + ")").css("background-color", "white");
  }
  if (colourY != null){
    $("table>thead>tr>th:nth-child(" + colourY + ")").css("background-color", "white");
  }
  $("table>thead>tr>th:nth-child(" + index + ")").css("background-color", "rgb(252, 103, 25)");
}

function Y_column(index) {
  if (colourY != null){
    $("table>thead>tr>th:nth-child(" + colourY + ")").css("background-color", "white");
  }
  $("table>thead:first-child>tr:first-child>th:nth-child(" + index + ")").css("background-color", "rgb(31,194,222)");
}

function Clear_column_colour(){
  for (var i = 0; i < size; i += 1){
    $("table>thead>tr>th:nth-child(" + i + ")").css("background-color", "white");
  }
  colourY = null;
}
