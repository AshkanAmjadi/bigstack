class allert {

    constructor({data}){
        this.data = {
            text: data.text || '',
            type: data.type || '',
            // withBorder: data.withBorder !== undefined ? data.withBorder : false,
            // withBackground: data.withBackground !== undefined ? data.withBackground : false,
            // stretched: data.stretched !== undefined ? data.stretched : false,
        };
        this.settings = [
            {
                name: 'Error',
                icon: `#e11d48`,
                type: `rose`
            },
            {
                name: 'Success',
                icon: `#10b981`,
                type: `emerald`

            },
            {
                name: 'Warning',
                icon: `#eab308`,
                type: `yellow`
            },
            {
                name: 'Secondary',
                icon: `#4b5563`,
                type: `gray`
            },
            {
                name: 'Info',
                icon: `#2563eb`,
                type: `blue`
            }

        ];
        this.wrapper = undefined;
    }
    static get toolbox() {
        return {
            title: 'Allert',
            icon: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="currentColor"><path d="M12 2C7.286 2 4.929 2 3.464 3.464C2 4.93 2 7.286 2 12c0 4.714 0 7.071 1.464 8.535C4.93 22 7.286 22 12 22c4.714 0 7.071 0 8.535-1.465C22 19.072 22 16.714 22 12s0-7.071-1.465-8.536C19.072 2 16.714 2 12 2Z" opacity=".5"/><path d="M12 6.25a.75.75 0 0 1 .75.75v6a.75.75 0 0 1-1.5 0V7a.75.75 0 0 1 .75-.75ZM12 17a1 1 0 1 0 0-2a1 1 0 0 0 0 2Z"/></g></svg>'
        };
    }

    render(){
        this.wrapper = document.createElement('div');
        let color = '#e11d48';
        let btn = ``;

        this.settings.forEach(tune =>{

            // console.log(tune,this.data)
            if (tune.type === this.data.type){
                color = tune.icon;
            }
            // console.log(color)
            btn = btn + `

            <div class="bg-white dark:bg-slate-800 flex items-center rounded-md p-2 cursor-pointer" onclick="changeAllertType(this,'${tune.type}','${tune.icon}')">
            <p>
            ${tune.name}
</p>
            <div class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="${tune.icon}"><path d="M12 2C7.286 2 4.929 2 3.464 3.464C2 4.93 2 7.286 2 12c0 4.714 0 7.071 1.464 8.535C4.93 22 7.286 22 12 22c4.714 0 7.071 0 8.535-1.465C22 19.072 22 16.714 22 12s0-7.071-1.465-8.536C19.072 2 16.714 2 12 2Z" opacity=".5"/><path d="M12 6.25a.75.75 0 0 1 .75.75v6a.75.75 0 0 1-1.5 0V7a.75.75 0 0 1 .75-.75ZM12 17a1 1 0 1 0 0-2a1 1 0 0 0 0 2Z"/></g></svg>
</div>

</div>

            `

        })

        this.wrapper.insertAdjacentHTML('afterbegin' , `

<div class="allertWraper p-2 rounded-md mb-2" style="background-color: ${color}">
       <textarea class="allertInput form-input w-full">${this.data && this.data.text ? this.data.text : ''}</textarea>
       <input type="hidden" class="allertType form-input w-full border-rose-500" value="${this.data && this.data.type ? this.data.type : 'red'}">

       <div class="allertChange flex flex-wrap gap-2">

${btn}

</div>
</div>
        `)


        return this.wrapper;
    }

    save(blockContent){
        const text =  blockContent.querySelector('.allertInput')
        const type = blockContent.querySelector('.allertType')

        return Object.assign(this.data, {
            text: text.value,
            type : type.value
        });
    }

    _toggleTune(tune){
        // console.log(`${tune} is clicked`)
        this.data.type = tune;
    }
}


function changeAllertType(El,type,color) {
    El.closest('.allertWraper').style.backgroundColor = color;
    El.closest('.allertWraper').querySelector('.allertType').value = type
}
