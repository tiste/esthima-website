export const request = async (url, data, method = 'GET', base = API_CONTACT, beforeSend = null, processData = true, contentType = "application/json") => {

  let params = {
    url: base + url,
    beforeSend: beforeSend,
    data,
    processData,
    method,
    xhrFields: {
      withCredentials: true
    },
    contentType
  }


  return jQuery.ajax(params)
}