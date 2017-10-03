<?php

function X_Bar_Validate($axistype){
  if ($axistype == 'VARCHAR(255)' || $axistype == 'DATETIME'){
    return true;
  }
  return false;
}

function Y_Bar_Validate($axistype){
  if ($axistype == 'INT' || $axistype == 'FLOAT'){
    return true;
  }
  return false;
}

function X_ScatterPlot_Validate($axistype){
  if ($axistype == 'INT' || $axistype == 'FLOAT'){
    return true;
  }
  return false;
}

function Y_ScatterPlot_Validate($axistype){
  if ($axistype == 'INT' || $axistype == 'FLOAT'){
    return true;
  }
  return false;
}

function X_LineDash_Validate($axistype){
  if ($axistype == 'INT' || $axistype == 'FLOAT'){
    return true;
  }
  return false;
}

function Y_LineDash_Validate($axistype){
  if ($axistype == 'INT' || $axistype == 'FLOAT'){
    return true;
  }
  return false;
}

function X_Bubble_Validate($axistype){
  if ($axistype == 'INT' || $axistype == 'FLOAT'){
    return true;
  }
  return false;
}

function Y_Bubble_Validate($axistype){
  if ($axistype == 'INT' || $axistype == 'FLOAT'){
    return true;
  }
  return false;
}

function X_ScatterLine_Validate($axistype){
  if ($axistype == 'INT' || $axistype == 'FLOAT'){
    return true;
  }
  return false;
}

function Y_ScatterLine_Validate($axistype){
  if ($axistype == 'INT' || $axistype == 'FLOAT'){
    return true;
  }
  return false;
}

function X_LineChart_Validate($axistype){
  if ($axistype == 'INT' || $axistype == 'FLOAT'){
    return true;
  }
  return false;
}


function Y_LineChart_Validate($axistype){
  if ($axistype == 'INT' || $axistype == 'FLOAT'){
    return true;
  }
  return false;
}

function X_OverlaidArea_Validate($axistype){
  if ($axistype == 'INT' || $axistype == 'FLOAT'){
    return true;
  }
  return false;
}


function Y_Overlaid_Validate($axistype){
  if ($axistype == 'INT' || $axistype == 'FLOAT'){
    return true;
  }
  return false;
}

function X_AreaHorizontalBar_Validate($axistype){
  if ($axistype == 'INT' || $axistype == 'FLOAT'){
    return true;
  }
  return false;
}

function Y_AreaHorizontalBar_Validate($axistype){
  if ($axistype == 'VARCHAR(255)' || $axistype == 'DATETIME'){
    return true;
  }
  return false;
}

function X_Pie_Validate($axistype){
  if ($axistype == 'INT' || $axistype == 'FLOAT'){
    return true;
  }
  return false;
}

function Y_Pie_Validate($axistype){
  if ($axistype == 'INT' || $axistype == 'FLOAT'){
    return true;
  }
  return false;
}
 ?>
