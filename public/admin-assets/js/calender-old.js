class CreateCalender {
    constructor(currentDate, selector, type, myCallBack, min, max) {
        this._currentDate = currentDate;
        this._selector = selector;
        this._type = type;
        this._selectedDate = null;
        this._myCallBack = myCallBack;
        this._min = min;
        this._max = max;
        this._cases = {
            case1: 'singleDatePicker',
            case2: 'weekPicker',
            case3: 'monthPicker',
        };
        this.drawMonth();
    }
    drawMonth = () => {
        this._selector.innerHTML = '';
        this.drawHeader();
        this.drawDates();
        this.drawFooter();
    }
    drawHeader = () => {
        let _dt = this._currentDate.clone().format("MMMM YYYY");

        let header = document.createElement('div');
        header.className = 'cl_header';

        let title = document.createElement('h4');
        title.innerText = _dt;

        let left = document.createElement('button');
        left.addEventListener('click', this.prevMonth);
        left.setAttribute('type', 'button');
        left.innerHTML = '<i class="fa fa-chevron-left"></i>';

        let right = document.createElement('button');
        right.addEventListener('click', this.nextMonth);
        right.setAttribute('type', 'button');
        right.innerHTML = '<i class="fa fa-chevron-right"></i>';

        header.appendChild(left);
        header.appendChild(title);
        header.appendChild(right);

        this._selector.appendChild(header);
    }
    drawDates = () => {
        let _date = this._currentDate.clone();
        // let firstWeek = _date.clone().month() === 0 ? 0 : _date.clone().startOf('month').isoWeek();
        let firstWeek =  _date.clone().startOf('month').isoWeek();
        let endWeek = _date.clone().endOf('month').isoWeek();
        let currentMonth = _date.clone().format('MM');
        console.log("🚀 ~ firstWeek", firstWeek, 'endWeek', endWeek);
        console.log("🚀 ~ firstWeek", _date.clone().startOf('month'), 'endWeek', _date.clone().endOf('month'));
        console.log("🚀🚀🚀",_date.clone().format('MM DD YYYY'), _date.clone().isoWeek(52).startOf('week'))

        let currentMonthDates = [];
        for (let i = firstWeek; i <= endWeek; i++) {
            for (let x = 0; x < 7; x++) {
                let val;
                val = _date.clone().isoWeek(i).startOf('week').add(x, 'days');
                currentMonthDates.push(val);
            }
        }

        let wrapper = document.createElement('div');
        wrapper.className = 'cl_body';

        // draw week
        let weekWrapper = document.createElement('div');
        weekWrapper.className = 'weeks';

        ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'].map((v, _) => {
            let ele = document.createElement('div');
            ele.innerText = v;
            weekWrapper.appendChild(ele);
        })

        // draw dates
        let datesWrapper = document.createElement('div');
        datesWrapper.className = 'dates';

        currentMonthDates.map((_d, _) => {
            let btn;
            btn = document.createElement('button');
            btn.innerText = _d.clone().format('D');
            btn.className = _d.clone().format('X') === this._selectedDate ? 'cl_date active' : 'cl_date';
            btn.setAttribute('type', 'button');
            if (_d.clone().format('MM') == currentMonth && _d.clone().day() !== 0 && _d.clone().day() !== 6) {
                if (!(this._min && this._max)) {
                    btn.addEventListener('click', this.handleDate);
                }
                if (!!this._min) {
                    if (_d.clone().isAfter(moment(this._min))) {
                        btn.addEventListener('click', this.handleDate);
                    } else {
                        btn.setAttribute('disabled', 'true');
                    }
                }
                if (!!this._max) {
                    if (_d.clone().isBefore(moment(this._max))) {
                        btn.addEventListener('click', this.handleDate);
                    } else {
                        btn.setAttribute('disabled', 'true');
                    }
                }
            } else {
                btn.setAttribute('disabled', 'true');
            }
            switch (this._type) {
                case this._cases.case1:
                    btn.setAttribute('data-label', _d.clone().format('X'));
                    break;
                case this._cases.case2:
                    console.log('weekPicker');
                    break;
                case this._cases.case3:
                    console.log('monthPicker');
                    break;
                default:
                    throw new Error('This action cannot be completed > ', this._type);
            }

            datesWrapper.appendChild(btn);
        })

        wrapper.appendChild(weekWrapper);
        wrapper.appendChild(datesWrapper);
        this._selector.appendChild(wrapper);
    }
    drawFooter = () => {
        let footer = document.createElement('div');
        footer.className = 'cl_footer';

        let cancel = document.createElement('button');
        cancel.addEventListener('click', this.clearSelection);
        cancel.setAttribute('type', 'button');
        cancel.innerText = 'cancel';

        let apply = document.createElement('button');
        apply.addEventListener('click', this.returnSelection);
        apply.setAttribute('type', 'button');
        apply.innerText = 'apply';

        footer.appendChild(cancel);
        footer.appendChild(apply);
        this._selector.appendChild(footer);
    }
    prevMonth = () => {
        this._currentDate = this._currentDate.clone().add(-1, 'M');
        this.drawMonth();
    }
    nextMonth = () => {
        this._currentDate = this._currentDate.clone().add(1, 'M');
        this.drawMonth();
    }
    handleDate = (e) => {
        switch (this._type) {
            case this._cases.case1:
                let val = e.target.getAttribute('data-label');
                if (e.target.classList.contains('active')) {
                    e.target.classList.remove('active');
                    this._selectedDate = null;
                } else {
                    if (!!this._selectedDate && this._selectedDate !== val) {
                        let childrens = e.target.parentNode.children;
                        Object.entries(childrens).filter(ele => {
                            ele[1].classList.remove('active')
                        })
                        e.target.classList.add('active');
                        this._selectedDate = val;
                    } else {
                        e.target.classList.add('active');
                        this._selectedDate = val;
                    }
                }
                break;
            case this._cases.case2:
                console.log('weekPicker');
                break;
            case this._cases.case3:
                console.log('monthPicker');
                break;
            default:
                throw new Error('This action cannot be completed > ', this._type);
        }

    }
    clearSelection = () => {
        switch (this._type) {
            case this._cases.case1:
                try {
                    Object.entries(this._selector.children).filter(ele => {
                        if (ele[1].classList.contains('cl_body')) {
                            Object.entries(ele[1].children[1].children).filter(item => {
                                item[1].classList.remove('active');
                                this._selectedDate = null;
                            })
                        }
                    })
                } catch (error) {
                    alert(error);
                }
                break;
            case this._cases.case2:
                console.log('weekPicker');
                break;
            case this._cases.case3:
                console.log('monthPicker');
                break;
            default:
                throw new Error('This action cannot be completed > ', this._type);
        }

    }
    returnSelection = () => {
        switch (this._type) {
            case this._cases.case1:
                if (!!this._selectedDate) {
                    this._myCallBack(moment.unix(this._selectedDate));
                } else {
                    this._myCallBack(null);
                }
                break;
            case this._cases.case2:
                console.log('weekPicker');
                break;
            case this._cases.case3:
                console.log('monthPicker');
                break;
            default:
                throw new Error('This action cannot be completed > ', this._type);
        }
    }
}