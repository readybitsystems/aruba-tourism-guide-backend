class CreateCalender {
    constructor(year, month, selector, type, min, max, myCallBack) {
        this._year = year;
        this._month = month;
        this._selector = selector;
        this._type = type;
        this._selectedDate = null;
        this._selectedWeek = null;
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

        let header = document.createElement('div');
        header.className = 'cl_header';

        let div = document.createElement('div');
        let btn = document.createElement('button');
        btn.innerHTML = moment([this._year, this._month - 1]).format("MMMM YYYY");
        btn.classList = 'dropdown_btn_992v';
        btn.setAttribute('type', 'button');
        btn.setAttribute('aria-expanded', 'false');
        btn.addEventListener('click', this.createDropDown);
        div.appendChild(btn);

        let left = document.createElement('button');
        left.addEventListener('click', this.prevMonth);
        left.setAttribute('type', 'button');
        left.innerHTML = '<i class="fa fa-chevron-left"></i>';

        let right = document.createElement('button');
        right.addEventListener('click', this.nextMonth);
        right.setAttribute('type', 'button');
        right.innerHTML = '<i class="fa fa-chevron-right"></i>';

        header.appendChild(left);
        header.appendChild(div);
        header.appendChild(right);

        this._selector.appendChild(header);
    }
    drawDates = () => {
        let _currentMonth = moment([this._year, this._month], 'YYYY MM');
        // create month array
        let allDates = this.createMonth(_currentMonth);

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
        // print complete month on dom
        this.printMonth(datesWrapper, allDates, _currentMonth);
        datesWrapper.className = 'dates';

        // append weeks in parent element
        wrapper.appendChild(weekWrapper);
        // append dates in parent element
        wrapper.appendChild(datesWrapper);
        this._selector.appendChild(wrapper);
    }
    createMonth = (_currentMonth) => {
        // month Start
        let startDay = _currentMonth.clone().startOf('month').day();
        let startDates = [];
        // month end
        let endDay = _currentMonth.clone().endOf('month').day();
        let endDates = [];
        let monthDates = [];
        if (startDay > 0) {
            for (let i = 0; i < 7 - (7 - startDay); i++) {
                let val;
                val = _currentMonth.clone().startOf('month').add(-(i + 1), 'days');
                startDates.push(val);
            }
        }
        if (endDay < 6) {
            for (let i = 0; i < 6 - endDay; i++) {
                let val;
                val = _currentMonth.clone().endOf('month').add((i + 1), 'days');
                endDates.push(val);
            }
        }
        for (let i = 0; i < _currentMonth.clone().endOf('month').format('D'); i++) {
            let val;
            val = _currentMonth.clone().startOf('month').add((i), 'days');
            monthDates.push(val);
        }
        return startDates.reverse().concat(monthDates, endDates);

    }
    printMonth = (datesWrapper, allDates, _currentMonth) => {
        allDates.map((_d, _i) => {
            let btn;
            btn = document.createElement('button');
            btn.innerText = _d.clone().format('D');
            btn.setAttribute('type', 'button');
            if (_d.clone().format('MM') === _currentMonth.format('MM') && _d.clone().day() !== 0 && _d.clone().day() !== 6) {
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
                    btn.className = _d.clone().format('X') === this._selectedDate ? 'cl_date active' : 'cl_date';
                    break;
                case this._cases.case2:
                    console.log('weekPicker');
                    let _key = Math.ceil((_i + 1) / 7);
                    btn.setAttribute('data-label', _d.clone().format('X'));
                    btn.setAttribute('data-key', _key);
                    btn.className = !!this._selectedWeek && moment.unix(this._selectedWeek[0].getAttribute("data-label")).format('MM') === _currentMonth.format('MM') && Number(this._selectedWeek[0].getAttribute("data-key")) === _key ? 'cl_date active' : 'cl_date';
                    break;
                case this._cases.case3:
                    console.log('monthPicker');
                    break;
                default:
                    throw new Error('This action cannot be completed > ', this._type);
            }
            datesWrapper.appendChild(btn);
        })
    }
    createDropDown = (e) => {
        let _container = e.target.parentNode;
        let _dropDownBtn = e.target;
        let _isOpen = _dropDownBtn.getAttribute('aria-expanded');
        console.log("🚀 _container", _container)
        console.log("🚀 _dropDownBtn", _dropDownBtn)
        console.log("🚀 _isOpen", _isOpen)
        if (_isOpen == 'true') {
            this.distroyDropDown(_dropDownBtn,_container);
        } else {
            _dropDownBtn.setAttribute('aria-expanded', 'true');
            let _dropDownContainer = document.createElement('div');
            _dropDownContainer.classList = 'dropdown_e0c58';
            for (let i = 0; i < 12; i++) {
                let item = document.createElement('button');
                item.setAttribute('type', 'button');
                item.setAttribute('data-month', i+1);
                item.innerText=moment(this._year,'YYYY').month(i).format("MMMM YYYY");
                item.addEventListener('click', this.jumpTo);
                item.classList = 'item_99c2';
                _dropDownContainer.appendChild(item);
            }
            _container.appendChild(_dropDownContainer);
        }
    }
    distroyDropDown=(_dropDownBtn,_container) => {
        _dropDownBtn.setAttribute('aria-expanded', 'false');
        _container.lastChild.remove();
    }
    jumpTo=(e)=>{
        let month=e.target.getAttribute('data-month')
        this._month=Number(month);
        this.drawMonth();
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
        if (this._month === 1) {
            this._year = --this._year;
        }
        if (this._month > 1) {
            this._month = --this._month;
        } else {
            this._month = 12;
        }
        this.drawMonth();
    }
    nextMonth = () => {
        if (this._month === 12) {
            this._year = ++this._year;
        }
        if (this._month > 11) {
            this._month = 1;
        } else {
            this._month = ++this._month;
        }
        this.drawMonth();
    }
    handleDate = (e) => {
        let val;
        switch (this._type) {
            case this._cases.case1:
                val = e.target.getAttribute('data-label');
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
                val = e.target.getAttribute('data-label');
                let _key = e.target.getAttribute('data-key');
                let selctedWeek = this._selector.querySelectorAll(`button[data-key="${_key}"]`);
                selctedWeek.forEach((_v, _i) => {
                    if (_v.classList.contains('active')) {
                        _v.classList.remove('active');
                        this._selectedWeek = null;
                    } else {
                        if (!!this._selectedWeek && this._selectedWeek[0].getAttribute("data-key") !== _key) {
                            let childrens = e.target.parentNode.children;
                            Object.entries(childrens).filter(ele => {
                                ele[1].classList.remove('active')
                            })
                            _v.classList.add('active');
                            this._selectedWeek = null;
                        } else {
                            _v.classList.add('active');
                        }
                    }
                });
                this._selectedWeek = selctedWeek;
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
                    if (!!this._selectedDate) {
                        Object.entries(this._selector.children).filter(ele => {
                            if (ele[1].classList.contains('cl_body')) {
                                Object.entries(ele[1].children[1].children).filter(item => {
                                    item[1].classList.remove('active');
                                    this._selectedDate = null;
                                })
                            }
                        })
                    }
                } catch (error) {
                    alert(error);
                }
                break;
            case this._cases.case2:
                if (!!this._selectedWeek) {
                    Object.entries(this._selector.children).filter(ele => {
                        if (ele[1].classList.contains('cl_body')) {
                            Object.entries(ele[1].children[1].children).filter(item => {
                                item[1].classList.remove('active');
                                this._selectedWeek = null;
                            })
                        }
                    })
                }
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
                console.log('singleDatePicker');
                if (!!this._selectedDate) {
                    // this._myCallBack(moment.unix(this._selectedDate));
                    this._myCallBack(this._selectedDate);
                } else {
                    this._myCallBack(null);
                }
                break;
            case this._cases.case2:
                console.log('weekPicker');
                let arr = [];
                if (!!this._selectedWeek) {
                    this._selectedWeek.forEach(_v => {
                        let stamp = _v.getAttribute("data-label");
                        arr.push(moment.unix(stamp))
                        arr.push(arr);
                    });
                    this._myCallBack(arr);
                } else {
                    this._myCallBack(null);
                }
                break;
            case this._cases.case3:
                console.log('monthPicker');
                break;
            default:
                throw new Error('This action cannot be completed > ', this._type);
        }
    }
}