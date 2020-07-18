if (!Array.prototype.forEach)
{
  Array.prototype.forEach = function(fun /*, thisp*/)
  {
    var len = this.length;
    if (typeof fun != "function")
      throw new TypeError();

    var thisp = arguments[1];
    for (var i = 0; i < len; i++)
    {
      if (i in this)
        fun.call(thisp, this[i], i, this);
    }
  };
}
        const Settings = {
            abc: ["A", "B", "C", "D", "E"]
        }
        const BaseURL = {
            domain:         "http://api.testyudt.com/",
            apiTestList:    "http://api.testyudt.com/index.php?api_key=cdad5e6b5ab66cd4e10b6ace30fee27c&api_tests_list=show",
            apiTest:        "http://api.testyudt.com/?api_key=cdad5e6b5ab66cd4e10b6ace30fee27c&api_test_name_all="
        }

        function show(e) {
            var href = e.getAttribute("href")
            href = href.replace("#", "")
            var url =  BaseURL.apiTest + href;
            const testNode = document.getElementById("test")
            testNode.innerHTML = ""
            fetchHTTPData("test", url, testNode)
        }

        
        function printTestList (data, parentNode) {
                data.forEach(function(testItem) {
                    var urlParam = testItem.url.split("api_test_name=");
                    parentNode.innerHTML = parentNode.innerHTML + '<li><a href="#' + urlParam[urlParam.length -1] + '" class = "" onClick="show(this)" > '+ testItem.name +'</a></li>'                    
                })
                loader(false)
            }


        
        function printTestAll (data, parentNode) {

            var lp = 1;
            data.forEach(function(testItem) {
                const id = "test-item-" + lp;
                const question = '<div id = "' + id +'"><h3>' + lp + '. ' + testItem.question + '</h3><ul class = "li-answers">'

                var questionsList = ""

                for (i = 0; i < testItem.answers.length; i++) {
                    if (testItem.values[i] == "1") {
                        questionsList = questionsList + '<li><span><b>' + Settings.abc[i] + '. ' + testItem.answers[i] + '</b></span></li>'
                    } else {
                        questionsList = questionsList + '<li>'+ Settings.abc[i] + '. ' + testItem.answers[i] + '</li>'
                    }
                    
                }
                parentNode.innerHTML = parentNode.innerHTML + question + questionsList + '</ul></div>'

                if (testItem.imageb64 != "0") {
  
                    const testItemNode = document.getElementById(id)
                    var image = new Image();
                    var src = "data:image/jpeg;base64," + testItem.imageb64
                    image.src = src;
                    testItemNode.appendChild(image);
                }

                lp++
            })

            loader(false)
        }

        function fetchHTTPData (print = "test-list", url = BaseURL.apiTestList, parentNode) {
            loader(true)

            fetch(url)
            .then(response => {
                return response.json()
            })
            .then(data => {
                if (print == "test-list") {
                    printTestList (data, parentNode)
                } else if (print == "test") {
                    printTestAll (data, parentNode)
                }
            })
            .catch(err => {
                console.log(err)
            })
        }

        function loader(show) {
            var loader = document.getElementById("loader")
            show ? loader.style.display = "block" : loader.style.display = "none"
        }

        document.addEventListener("DOMContentLoaded", function (event) {
            const testListNode = document.getElementById("test-list")
            fetchHTTPData("test-list", BaseURL.apiTestList, testListNode)
        })