var elements = document.querySelectorAll('[href="href_value"]');

elements.forEach(ele =>{
    ele.addEventListener('click',() =>{

    })
});


$('.ui.search')
    .search({
        type          : 'category',
        minCharacters : 2,
        apiSettings   : {
            onResponse: res => {
                var
                    response = {
                        results : {}
                    }
                ;
                // translate API response to work with search
                $.each(res.items, function(index, item) {
                    var
                        category   = item.category || 'Unknown',
                        maxResults = 8
                    ;
                    if(index >= maxResults) {
                        return false;
                    }
                    // create new language category
                    if(response.results[category] === undefined) {
                        response.results[category] = {
                            name    : category,
                            results : []
                        };
                    }
                    // add result to category
                    response.results[category].results.push({
                        title       : item.display,
                        description : item.description,
                        url         : item.url
                    });
                });
                return response;
            },
            url: '/search/{query}'
        }
    })
;
