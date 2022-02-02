const calculateMape = (data) => {
    // console.log('I would calculate MAPE: ', data);

    // PBD = 0 means Final Orders
    let finalOrder = data.filter((el) => {
        return el.PeriodsBeforeDelivery == 0;
    });

    let finalOrdersForecastPeriods = new Map();
    finalOrder.map(e => {
        finalOrdersForecastPeriods.set(e.ForecastPeriod, e.OrderAmount);
    });
    // PBD != 0 means all Others or Forecast Orders
    let uniqueArray = data.filter(function (obj) {
        return finalOrder.indexOf(obj) == -1;
    });
    //Find the max number of Actual periods in Final orders array
    let maxActualPeriod = Math.max.apply(Math, finalOrder.map(function (o) {
        return o.ActualPeriod;
    }))

    // Order the Products by PBD in order to calculate sum of Forecasts and FinalOrders
    let orderByPBD = d3.nest()
        .key(function (d) {
            return d.PeriodsBeforeDelivery;
        })
        .entries(uniqueArray);

    // Calculate the sum for the Forecasts for each pbd != 0
    let calculationsOrderByPBD = orderByPBD.map((el) => {
        for (i = 0; i < orderByPBD.length; i++) {
            const uniqueNames = [...new Set(el.values.map(i => i.Product))];

            // Forecast Sums
            let validForecasts = el.values.filter(e => e.ForecastPeriod <= maxActualPeriod);

            let forecastOrdersForecastPeriods = new Map();
            validForecasts.map(e => {
                forecastOrdersForecastPeriods.set(e.ForecastPeriod, e.OrderAmount);
            });

            // FinalOrder Sums
            let items = el.values;
            let forecastItems = items.map(el => el.ForecastPeriod);
            let sumFinalOrders = 0;
            let difference = [];
            forecastItems.forEach(e => {
                if (finalOrdersForecastPeriods.get(e) !== undefined) {
                    sumFinalOrders += parseInt(finalOrdersForecastPeriods.get(e), 0);
                    difference.push(Math.abs(finalOrdersForecastPeriods.get(e) -
                        forecastOrdersForecastPeriods.get(e)));
                }
            });

            let sumOfDifferences = difference.reduce((a, b) => +a + +b, 0);

            let mapeValue = sumOfDifferences / sumFinalOrders;

            return {
                Product: uniqueNames[i],
                PeriodsBeforeDelivery: el.key,
                MAPE: mapeValue.toFixed(3)
            }
        }
    });
    return calculationsOrderByPBD;
}

const calculateMAD = (data) => {
    // console.log('I would calculate MAD: ', data);

    let absDiff = function (orignalEl, finalOrder) {
        return Math.abs(orignalEl.OrderAmount - finalOrder);
    }

    let finalOrder = data.filter((el) => {
        return el.PeriodsBeforeDelivery == 0;
    });

    let uniqueArray = data.filter(function (obj) {
        return finalOrder.indexOf(obj) == -1;
    });

    let valueMap = new Map();
    finalOrder.forEach((val) => {
        let keyString = val.ActualPeriod;
        let valueString = val.OrderAmount;
        valueMap.set(keyString, valueString);
    });

    let absValuesArray = uniqueArray.map((el) => {
        let value = absDiff(el, valueMap.get(el.ForecastPeriod));
        return {
            ActualDate: el.ActualDate,
            ForecastDate: el.ForecastDate,
            ActualPeriod: el.ActualPeriod,
            ForecastPeriod: el.ForecastPeriod,
            OrderAmount: el.OrderAmount,
            Product: el.Product,
            PeriodsBeforeDelivery: el.PeriodsBeforeDelivery,
            AbsoluteDiff: value
        };
    });

    let seperatedByPeriods = d3.nest()
        .key(function (d) {
            return d.PeriodsBeforeDelivery
        })
        .entries(absValuesArray);

    let madCalc = seperatedByPeriods.map((el) => {
        for (i = 0; i < seperatedByPeriods.length; i++) {
            let meanValue = d3.mean(el.values, function (d) {
                return d.AbsoluteDiff;
            });
            return {
                Product: el.values[i].Product,
                PeriodsBeforeDelivery: el.key,
                MAD: meanValue.toFixed(3)
            };
        }
    });
    finalMADCalc = madCalc.filter((el) => {
        return !isNaN(el.MAD);
    })

    return finalMADCalc;
}
const calculateMD = (data) => {
    let absDiff = function (orignalEl, finalOrder) {
        return orignalEl.OrderAmount - finalOrder;
    }
    let finalOrder = data.filter((el) => {
        return el.PeriodsBeforeDelivery == 0;
    });
    let uniqueArray = data.filter(function (obj) {
        return finalOrder.indexOf(obj) == -1;
    });

    let valueMap = new Map();
    finalOrder.forEach((val) => {
        let keyString = val.ActualPeriod;
        let valueString = val.OrderAmount;
        valueMap.set(keyString, valueString);
    });

    let absValuesArray = uniqueArray.map((el) => {
        let value = absDiff(el, valueMap.get(el.ForecastPeriod));
        return {
            ActualDate: el.ActualDate,
            ForecastDate: el.ForecastDate,
            ActualPeriod: el.ActualPeriod,
            ForecastPeriod: el.ForecastPeriod,
            OrderAmount: el.OrderAmount,
            Product: el.Product,
            PeriodsBeforeDelivery: el.PeriodsBeforeDelivery,
            AbsoluteDiff: value
        };
    });

    let seperatedByPeriods = d3.nest()
        .key(function (d) {
            return d.PeriodsBeforeDelivery
        })
        .entries(absValuesArray);

    let mdCalc = seperatedByPeriods.map((el) => {
        for (i = 0; i < seperatedByPeriods.length; i++) {
            let meanValue = d3.mean(el.values, function (d) {
                return d.AbsoluteDiff;
            });
            return {
                Product: el.values[i].Product,
                PeriodsBeforeDelivery: el.key,
                MD: meanValue.toFixed(3)
            };
        }
    });
    finalMDCalc = mdCalc.filter((el) => {
        return !isNaN(el.MD);
    })

    return finalMDCalc;
}

const calculateMSE = (data) => {
    let finalOrder = data.filter((el) => {
        return el.PeriodsBeforeDelivery == 0;
    });
    let absDiff = function (orignalEl, finalOrder) {
        return Math.pow((orignalEl.OrderAmount - finalOrder), 2);
    }
    let uniqueArray = data.filter(function (obj) {
        return finalOrder.indexOf(obj) == -1;
    });
    let valueMap = new Map();
    finalOrder.forEach((val) => {
        let keyString = val.ActualPeriod;
        let valueString = val.OrderAmount;
        valueMap.set(keyString, valueString);
    });
    let absValuesArray = uniqueArray.map((el) => {
        let value = absDiff(el, valueMap.get(el.ForecastPeriod));
        return {
            ActualDate: el.ActualDate,
            ForecastDate: el.ForecastDate,
            ActualPeriod: el.ActualPeriod,
            ForecastPeriod: el.ForecastPeriod,
            OrderAmount: el.OrderAmount,
            Product: el.Product,
            PeriodsBeforeDelivery: el.PeriodsBeforeDelivery,
            AbsoluteDiff: value
        };
    });

    let seperatedByPeriods = d3.nest()
        .key(function (d) {
            return d.PeriodsBeforeDelivery
        })
        .entries(absValuesArray);

    let mseCalc = seperatedByPeriods.map((el) => {
        for (i = 0; i < seperatedByPeriods.length; i++) {
            let meanValue = d3.mean(el.values, function (d) {
                return d.AbsoluteDiff;
            });
            return {
                Product: el.values[i].Product,
                PeriodsBeforeDelivery: el.key,
                MSE: meanValue.toFixed(3)
            };
        }
    });
    finalMSECalc = mseCalc.filter((el) => {
        return !isNaN(el.MSE);
    })
    return finalMSECalc;
}
const calculateRMSE = (data) => {
    let finalOrder = data.filter((el) => {
        return el.PeriodsBeforeDelivery == 0;
    });
    let powerDiff = function (orignalEl, finalOrder) {
        return Math.pow((orignalEl.OrderAmount - finalOrder), 2);
    }
    let uniqueArray = data.filter(function (obj) {
        return finalOrder.indexOf(obj) == -1;
    });

    let valueMap = new Map();
    finalOrder.forEach((val) => {
        let keyString = val.ActualPeriod;
        let valueString = val.OrderAmount;
        valueMap.set(keyString, valueString);
    });

    let squaredAbsValuesArray = uniqueArray.map((el) => {
        let value = powerDiff(el, valueMap.get(el.ForecastPeriod));
        return {
            ActualDate: el.ActualDate,
            ForecastDate: el.ForecastDate,
            ActualPeriod: el.ActualPeriod,
            ForecastPeriod: el.ForecastPeriod,
            OrderAmount: el.OrderAmount,
            Product: el.Product,
            PeriodsBeforeDelivery: el.PeriodsBeforeDelivery,
            SquaredAbsoluteDiff: value
        };
    });

    let seperatedByPeriods = d3.nest()
        .key(function (d) {
            return d.PeriodsBeforeDelivery
        })
        .entries(squaredAbsValuesArray);

    let rmseCalc = seperatedByPeriods.map((el) => {
        for (i = 0; i < seperatedByPeriods.length; i++) {
            let meanValue = Math.sqrt(d3.mean(el.values, function (d) {
                return d.SquaredAbsoluteDiff;
            }), 2);
            return {
                Product: el.values[i].Product,
                PeriodsBeforeDelivery: el.key,
                RMSE: meanValue.toFixed(3)
            };
        }
    });
    finalRMSECalc = rmseCalc.filter((el) => {
        return !isNaN(el.RMSE);
    })
    return finalRMSECalc;
}

const calculateNormRMSE = (data) => {
    let finalOrder = data.filter((el) => {
        return el.PeriodsBeforeDelivery == 0;
    });
    let finalOrderForecastPeriods = finalOrder.map(e => e.ForecastPeriod);

    let finalOrdersForecastPeriods = new Map();
    finalOrder.map(e => {
        finalOrdersForecastPeriods.set(e.ForecastPeriod, e.OrderAmount);
    });

    let powerDiff = function (orignalEl, finalOrder) {
        return Math.pow((orignalEl.OrderAmount - finalOrder), 2);
    }
    let uniqueArray = data.filter(function (obj) {
        return finalOrder.indexOf(obj) == -1;
    });
    let valueMap = new Map();
    finalOrder.forEach((val) => {
        let keyString = val.ActualPeriod;
        let valueString = val.OrderAmount;
        valueMap.set(keyString, valueString);
    });

    let orderByPBD = d3.nest()
        .key(function (d) {
            return d.PeriodsBeforeDelivery;
        })
        .entries(uniqueArray);

    let calculationsOrderByPBD = orderByPBD.map((elem) => {
        let pbdForecasts = elem.values.map(e => e.ForecastPeriod);
        // ALL valid Forecast Periods for each Period before delivery
        let validForecasts = finalOrderForecastPeriods.filter(value => -1 !== pbdForecasts
            .indexOf(value));

        let noFinalOrders = validForecasts.length;

        let sumFinalOrders = 0;
        validForecasts.forEach(e => {
            if (finalOrdersForecastPeriods.get(e) !== undefined) {
                sumFinalOrders += parseInt(finalOrdersForecastPeriods.get(e), 0);
            }
        });
        let meanFinalOrders = sumFinalOrders / noFinalOrders;

        return {
            PeriodsBeforeDelivery: elem.key,
            MeanFinalOrders: meanFinalOrders
        }
    });

    let squaredAbsValuesArray = uniqueArray.map((el) => {
        let value = powerDiff(el, valueMap.get(el.ForecastPeriod));
        return {
            ActualDate: el.ActualDate,
            ForecastDate: el.ForecastDate,
            ActualPeriod: el.ActualPeriod,
            ForecastPeriod: el.ForecastPeriod,
            OrderAmount: el.OrderAmount,
            Product: el.Product,
            PeriodsBeforeDelivery: el.PeriodsBeforeDelivery,
            MeanFinalOrders: el.MeanFinalOrders,
            SquaredAbsoluteDiff: value
        };
    });

    var squaredAbsValuesArray2 = squaredAbsValuesArray.reduce((arr, e) => {
        arr.push(Object.assign({}, e, calculationsOrderByPBD.find(a => a
            .PeriodsBeforeDelivery == e.PeriodsBeforeDelivery)))
        return arr;
    }, [])

    let seperatedByPeriods = d3.nest()
        .key(function (d) {
            return d.PeriodsBeforeDelivery
        })
        .entries(squaredAbsValuesArray2);

    let normRmseCalc = seperatedByPeriods.map((el) => {
        for (i = 0; i < seperatedByPeriods.length; i++) {
            let meanValue = Math.sqrt(d3.mean(el.values, function (d) {
                return d.SquaredAbsoluteDiff;
            }), 2);
            let normRMSE = meanValue / el.values[i].MeanFinalOrders;
            return {
                Product: el.values[i].Product,
                PeriodsBeforeDelivery: el.key,
                // RMSE: meanValue,
                NRMSE: normRMSE.toFixed(3)
            };
        }
    });
    finalNRMSECalc = normRmseCalc.filter((el) => {
        return !isNaN(el.NRMSE);
    })
    return finalNRMSECalc;
}
const calculateMPE = (data) => {
    let finalOrder = data.filter((el) => {
        return el.PeriodsBeforeDelivery == 0;
    });

    let finalOrdersForecastPeriods = new Map();
    finalOrder.map(e => {
        finalOrdersForecastPeriods.set(e.ForecastPeriod, e.OrderAmount);
    });

    // PBD != 0 means all Others or Forecast Orders
    let uniqueArray = data.filter(function (obj) {
        return finalOrder.indexOf(obj) == -1;
    });
    //Find the max number of Actual periods in Final orders array
    let maxActualPeriod = Math.max.apply(Math, finalOrder.map(function (o) {
        return o.ActualPeriod;
    }))

    // Order the Products by PBD in order to calculate sum of Forecasts and FinalOrders
    let orderByPBD = d3.nest()
        .key(function (d) {
            return d.PeriodsBeforeDelivery;
        })
        .entries(uniqueArray);

    // Calculate the sum for the Forecasts for each pbd != 0
    let finalMPEcalc = orderByPBD.map((el) => {
        for (i = 0; i < orderByPBD.length; i++) {
            const uniqueNames = [...new Set(el.values.map(i => i.Product))];

            // Forecast Sums
            let validForecasts = el.values.filter(e => e.ForecastPeriod <= maxActualPeriod);

            let forecastOrdersForecastPeriods = new Map();
            validForecasts.map(e => {
                forecastOrdersForecastPeriods.set(e.ForecastPeriod, e.OrderAmount);
            });

            // FinalOrder Sums
            let items = el.values;
            let forecastItems = items.map(el => el.ForecastPeriod);
            let sumFinalOrders = 0;
            let difference = [];
            forecastItems.forEach(e => {
                if (finalOrdersForecastPeriods.get(e) !== undefined) {
                    sumFinalOrders += parseInt(finalOrdersForecastPeriods.get(e), 0);
                    difference.push(forecastOrdersForecastPeriods.get(e) -
                        finalOrdersForecastPeriods.get(e));
                }
            });
            let sumOfDifferences = difference.reduce((a, b) => +a + +b, 0);

            // MPE
            // let mfbValue = sumOfForecasts / sumFinalOrders;
            let mpeValue = sumOfDifferences / sumFinalOrders;

            return {
                Product: uniqueNames[i],
                PeriodsBeforeDelivery: el.key,
                // MFB: mfbValue.toFixed(3),
                MPE: mpeValue.toFixed(3)
            }
        }
    });
    return finalMPEcalc;
}

const calculateMFB = (data) => {
    let finalOrder = data.filter((el) => {
        return el.PeriodsBeforeDelivery == 0;
    });
    let finalOrdersForecastPeriods = new Map();
    finalOrder.map(e => {
        finalOrdersForecastPeriods.set(e.ForecastPeriod, e.OrderAmount);
    });

    // PBD != 0 means all Others or Forecast Orders
    let uniqueArray = data.filter(function (obj) {
        return finalOrder.indexOf(obj) == -1;
    });
    //Find the max number of Actual periods in Final orders array
    let maxActualPeriod = Math.max.apply(Math, finalOrder.map(function (o) {
        return o.ActualPeriod;
    }))

    // Order the Products by PBD in order to calculate sum of Forecasts and FinalOrders
    let orderByPBD = d3.nest()
        .key(function (d) {
            return d.PeriodsBeforeDelivery;
        })
        .entries(uniqueArray);

    // Calculate the sum for the Forecasts for each pbd != 0
    let finalMFBCalc = orderByPBD.map((el) => {
        for (i = 0; i < orderByPBD.length; i++) {
            const uniqueNames = [...new Set(el.values.map(i => i.Product))];

            // Forecast Sums
            let validForecasts = el.values.filter(e => e.ForecastPeriod <= maxActualPeriod);
            let forecastOrdersForecastPeriods = new Map();
            validForecasts.map(e => {
                forecastOrdersForecastPeriods.set(e.ForecastPeriod, e.OrderAmount);
            });

            // FinalOrder Sums
            let items = el.values;
            items = items.map(el => el.ForecastPeriod);
            let sumFinalOrders = 0;
            let forecastSum = 0;
            items.forEach(e => {
                if (finalOrdersForecastPeriods.get(e) !== undefined) {
                    sumFinalOrders += parseInt(finalOrdersForecastPeriods.get(e), 0);
                    forecastSum += parseInt(forecastOrdersForecastPeriods.get(e), 0);
                }
            });
            // MFB
            let mfbValue = forecastSum / sumFinalOrders;

            return {
                Product: uniqueNames[i],
                PeriodsBeforeDelivery: el.key,
                MFB: mfbValue.toFixed(3)
            }
        }
    });
    return finalMFBCalc;
}