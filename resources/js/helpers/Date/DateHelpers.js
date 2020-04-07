const months = ['январь', 'февраль', 'март', 'апрель', 'май', 'июнь', 'июль', 'август', 'сентябрь', 'октябрь', 'ноябрь', 'декабрь'];

const months2 = ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'];

const weekDay = ['понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота', 'воскресенье'];

export const getRuMonth = (number, declension = false) => {
    return declension ? months2[number] : months[number];
};

export const getRuDay = number => {
    return weekDay[number - 1];
};

export const getDateString = date => {
    let day = date.getDate();
    if(day < 10) {
        day = `0${day}`
    }

    let month = date.getMonth()+1;
    if(month < 10) {
        month = `0${month}`
    }

    return `${day}-${month}-${date.getFullYear()}`
};
