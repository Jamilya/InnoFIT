const getAppropriateDimensions = () => {
    const screenW = window.screen.width;
    const screenH = window.screen.height;

    // Default Sizes
    let defaultWidth = 768;
    let defaultHeight = 480;

    if (screenW < 1280 && screenH < 720) {
        return { width: 300, height: 150 };
    } else if (screenW < 1920 && screenW >= 1280 && screenH < 1080 && screenH >= 720) {
        return { width: 600, height: 400 };
    }
    else {
        return { width: defaultWidth, height: defaultHeight };
    }
}

const getPercentToPixelDimensions = (widthPercent = 100, heightPercent = 100) => {
    const screenW = window.screen.width;
    const screenH = window.screen.height;

    const newWidth = screenW * (widthPercent / 100);
    const newHeight = screenH * (heightPercent / 100);

    return { width: newWidth, height: newHeight };
}

/**
 * This smart tick function (getSmartTicks) generates a desirable range of data, 
 * cut by the most appopriate rounded step depending on the maximum value of 
 * the given dataset.
*/
function getSmartTicks(val) {
    // Base step between nearby two ticks
    let step = Math.pow(10, val.toString().length - 1);
  
    // Modify steps either: 1, 2, 5, 10, 20, 50, 100, 200, 500, 1000, 2000...
    if (val / step < 2) {
        step = step / 5;
    } else if (val / step < 5) {
        step = step / 2;
    }
  
    // Add one more step if the last tick value is the same as the max value
    // If you don't want to add, remove "+1"
    var slicesCount = Math.ceil((val + 1) / step);
  
    return {
      endPoint: slicesCount * step,
      count: Math.min(10, slicesCount) //show max 10 ticks
    };
}