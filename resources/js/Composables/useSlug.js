import {computed, watch, ref, watchEffect} from "vue";

export function useSlug(inputValue = null){
    const makeSlug = (text=null)=>{
        const a = 'àáäâèéëêìíïîòóöôùúüûñçßÿỳýœæŕśńṕẃǵǹḿǘẍźḧ'
        const b = 'aaaaeeeeiiiioooouuuuncsyyyoarsnpwgnmuxzh'
        const p = new RegExp(a.split('').join('|'), 'g')
        const ampersand = 'and'
        if (text != null){
            return text.toString().toLowerCase()
                .replace(/[\s_]+/g, '-')
                .replace(p, c =>
                    b.charAt(a.indexOf(c)))
                .replace(/&/g, `-${ampersand}-`)
                .replace(/[^\w-]+/g, '')
                .replace(/--+/g, '-')
                .replace(/^-+|-+$/g, '')
        }
    }

    return {makeSlug};
}
