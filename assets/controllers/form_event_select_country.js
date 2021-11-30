
const spinner_country = document.querySelector('#form_country');
const spinner_city   = document.querySelector('#form_city');


spinner_country.addEventListener('change', function(event){
    
    let id = event.target.value;

    if(!id){ 
        console.log('select placehold')
        spinner_city.disabled = true;
    }else{   
        console.log(id)
        spinner_city.disabled = false;

        removeAll(spinner_city);
       
        axios.get('https://127.0.0.1:8000/updateselect/'+id)
             .then((response) => { 
                Object.entries(response.data['data']).forEach( ([ key, value]) => {
                    const city = { 
                        'id': value.id ,
                        'value': value.name 
                    };
                    spinner_city.appendChild(  creatOption( city ) );
                });

            })
             .catch(e => console.log(e))
       
    }
})


function creatOption({id, value}){
     
        // create option using DOM
        const newOption = document.createElement('option');
        const optionText = document.createTextNode(value);
        // set option text
        newOption.appendChild(optionText);
        // and option value
        newOption.setAttribute('id', id);

        return newOption;

}


function removeAll(selectBox) {
    while (selectBox.options.length > 0) {
        selectBox.remove(0);
    }
}


// Function to define innerHTML for HTML table
function show(data) {
    let tab = 
        `<tr>
          <th>Name</th>
         </tr>`;
    
    // Loop to access all rows 
    for (let r of data.list) {
        tab += `<tr> 
    <td>${r.name} </td>
           
</tr>`;
    }
    // Setting innerHTML as tab variable
    document.getElementById("employees").innerHTML = tab;
}