function doGetJson(e) {
    const sheet = SpreadsheetApp.openById("1qiiZ1qE_EYteqS_mh9tLXVnkMnRr3-IlflpjvzI_2ko").getSheetByName("Puchiduen");
    const data = sheet.getDataRange().getDisplayValues();
    const query = e.parameter.q;
    
    // Find the last row that matches the query
    const lastMatchingRow = [...data.slice(1)].reverse().find(row => {
      return !query || row[0] === query;
    });
  
    // Convert last matching row to an object if found, else return an empty object
    const result = lastMatchingRow ? lastMatchingRow.reduce((obj, value, index) => {
      obj['column' + (index + 1)] = value;
      return obj;
    }, {}) : {};
  
    return ContentService.createTextOutput(JSON.stringify([result])).setMimeType(ContentService.MimeType.JSON);
  }
  