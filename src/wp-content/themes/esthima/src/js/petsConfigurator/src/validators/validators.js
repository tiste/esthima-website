const rangeLatin = 'a-zA-ZáàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ'

export const phone = (value) => {
    if (typeof value === 'undefined' || value === null || value === '') {
        return true
    }
    // let r =  /^((0[0-9])(\d{2}){3}\d{2})$/.test(value)
    const r = /^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/gmi
    return r.test(value)
}

export const regexNom = function regexNom(val) {
    const regex = new RegExp('^[' + rangeLatin + '\-\\s\']+[' + rangeLatin + ']+$')
    return regex.test(val)
}