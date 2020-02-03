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