Date.prototype.AddDays = function(days) {
    this.setDate(this.getDate() + days);
    return this;
}

Date.prototype.AddHours = function(hours) {
    this.setHours(this.getHours() + hours);
    return this;
}

Date.prototype.AddMilliseconds = function(milliseconds) {
    this.setMilliseconds(this.getMilliseconds() + milliseconds);
    return this;
}

Date.prototype.AddMinutes = function(minutes) {
    this.setMinutes(this.getMinutes() + minutes, this.getSeconds(), this.getMilliseconds());
    return this;
}

Date.prototype.AddMonths = function(months) {
    this.setMonth(this.getMonth() + months, this.getDate());
    return this;
}

Date.prototype.AddSeconds = function(seconds) {
    this.setSeconds(this.getSeconds() + seconds, this.getMilliseconds());
    return this;
}

Date.prototype.AddYears = function(years) {
    this.setFullYear(this.getFullYear() + years);
    return this;
}