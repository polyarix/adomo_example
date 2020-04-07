export default (status) => {
    status = +status;

    if(status === 5) return 'Отлично';
    if(status === 4) return 'Хорошо';
    if(status === 3) return 'Нормально';
    if(status === 2) return 'Плохо';
    if(status === 1) return 'Ужасно';

    return 'Неопознано :(';
}
