const EMAIL_VERIFY_REGEX = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

export const isValidEmail = (mail) => {
    return EMAIL_VERIFY_REGEX.test(mail);
};

export const isValidPhone = (number) => {
    return number.length === 16;
};

export const isValidDate = (dateString) => {
    // First check for the pattern
    if(!/^\d{1,2}-\d{1,2}-\d{4}$/.test(dateString))
        return false;

    return true;

    // Parse the date parts to integers
    var parts = dateString.split("/");
    var day = parseInt(parts[1], 10);
    var month = parseInt(parts[0], 10);
    var year = parseInt(parts[2], 10);

    // Check the ranges of month and year
    if(year < 1000 || year > 3000 || month === 0 || month > 12)
        return false;

    var monthLength = [ 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];

    // Adjust for leap years
    if(year % 400 === 0 || (year % 100 !== 0 && year % 4 === 0))
        monthLength[1] = 29;

    // Check the range of the day
    return day > 0 && day <= monthLength[month - 1];
};
