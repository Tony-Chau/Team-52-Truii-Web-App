//This function connects all the other functions below
function ChartValidate(charttype, axis, axistype){
  if (charttype == 'Scatter plot'){
    if (axis == 'x'){
      return X_ScatterPlot_Validate(axistype);
    }
    return Y_ScatterPlot_Validate(axistype);
  }
  if(charttype == 'Line Dash'){
    if (axis == 'x'){
      return X_LineDash_Validate(axistype);
    }
    return Y_LineDash_Validate(axistype);
  }
  if(charttype == 'Bubble'){
    if (axis == 'x'){
      return X_Bubble_Validate(axistype);
    }
    return Y_Bubble_Validate(axistype);
  }
  if(charttype == 'Bar'){
    if (axis == 'x'){
      return X_Bar_Validate(axistype);
    }
    return Y_Bar_Validate(axistype);
  }
  if (charttype == 'Scatter Line'){
    if (axis == 'x'){
      return X_ScatterPlot_Validate(axistype);
    }
    return Y_ScatterPlot_Validate(axistype);
  }
  if (charttype == 'Line'){
    if (axis == 'x'){
      return X_LineChart_Validate(axistype);
    }
    return Y_LineChart_Validate(axistype);
  }
  if (charttype == 'Overlaid Area'){
    if (axis == 'x'){
      return X_OverlaidArea_Validate(axistype);
    }
    return Y_Overlaid_Validate(axistype);
  }
  if (charttype == 'Horizontal Bar'){
    if (axis == 'x'){
      return X_AreaHorizontalBar_Validate(axistype);
    }
    return Y_AreaHorizontalBar_Validate(axistype);
  }
  if (charttype == 'Pie'){
    if (axis == 'x'){
      return X_Pie_Validate(axistype);
    }
    return Y_Pie_Validate(axistype);
  }
  return false;
}

function X_Bar_Validate(axistype){
  if (axistype == 'INT' || axistype == 'FLOAT'){
    return true;
  }
  return false;
}

function Y_Bar_Validate(axistype){
  if (axistype == 'VARCHAR(255)' || axistype == 'TIME' || axistype == 'DATE'){
    return true;
  }
  return false;
}

function X_ScatterPlot_Validate(axistype){
  if (axistype == 'INT' || axistype == 'FLOAT'){
    return true;
  }
  return false;
}

function Y_ScatterPlot_Validate(axistype){
  if (axistype == 'INT' || axistype == 'FLOAT'){
    return true;
  }
  return false;
}

function X_LineDash_Validate(axistype){
  if (axistype == 'INT' || axistype == 'FLOAT'){
    return true;
  }
  return false;
}

function Y_LineDash_Validate(axistype){
  if (axistype == 'INT' || axistype == 'FLOAT'){
    return true;
  }
  return false;
}

function X_Bubble_Validate(axistype){
  if (axistype == 'INT' || axistype == 'FLOAT'){
    return true;
  }
  return false;
}

function Y_Bubble_Validate(axistype){
  if (axistype == 'INT' || axistype == 'FLOAT'){
    return true;
  }
  return false;
}

function X_ScatterLine_Validate(axistype){
  if (axistype == 'INT' || axistype == 'FLOAT'){
    return true;
  }
  return false;
}

function Y_ScatterLine_Validate(axistype){
  if (axistype == 'INT' || axistype == 'FLOAT'){
    return true;
  }
  return false;
}

function X_LineChart_Validate(axistype){
  if (axistype == 'INT' || axistype == 'FLOAT'){
    return true;
  }
  return false;
}


function Y_LineChart_Validate(axistype){
  if (axistype == 'INT' || axistype == 'FLOAT'){
    return true;
  }
  return false;
}

function X_OverlaidArea_Validate(axistype){
  if (axistype == 'INT' || axistype == 'FLOAT'){
    return true;
  }
  return false;
}


function Y_Overlaid_Validate(axistype){
  if (axistype == 'INT' || axistype == 'FLOAT'){
    return true;
  }
  return false;
}

function X_AreaHorizontalBar_Validate(axistype){
  if (axistype == 'INT' || axistype == 'FLOAT'){
    return true;
  }
  return false;
}

function Y_AreaHorizontalBar_Validate(axistype){
  if (axistype == 'VARCHAR(255)' || axistype == 'TIME' || axistype == 'DATE'){
    return true;
  }
  return false;
}

function X_Pie_Validate(axistype){
  if (axistype == 'INT' || axistype == 'FLOAT'){
    return true;
  }
  return false;
}

function Y_Pie_Validate(axistype){
  if (axistype == 'VARCHAR(255)' || axistype == 'TIME' || axistype == 'DATE'){
    return true;
  }
  return false;
}
