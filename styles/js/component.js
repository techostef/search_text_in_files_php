jQuery(document).ready(function($){
    var nameSearchArr = [];
    var nameSearch;
    var temp;
    
    $("#searchNamebutton").click(function(){
        nameSearch = $("#namesearch").val();
        nameSearchArr = [];
        $("input").each(function(){
            if($(this).attr("data-type")=="file"){
                temp = $(this).attr("data-url");
                temp = temp.split("/");
                if(temp.length>1){
                    temp = temp[temp.length-1];
                    temp = temp.toLowerCase();
                    if(temp.indexOf(nameSearch)>=0){
                        temp = '<li class="pft-file ext-php active">';
                        temp += $(this).parent().html();
                        temp += "</li>";
                        nameSearchArr.push(temp);
                    }
                }
            }
        })

        $(".resultSearch").html("");
        nameSearchArr.forEach(function(item,index){
            temp = $(".resultSearch").append(item);
            temp.addClass("listStyle-none");
            temp.find("input").remove();
        })
    })
    $("body").on("click",".openTextEditor",function(){
        var url = window.location.protocol+"//"+window.location.hostname+window.location.pathname;
        var bg = $("body").css("background");
        var color = $("body").css("color");
        var path = $(this).attr("data-text")?$(this).attr("data-text"):"";
        path = $(this).attr("data-url")?$(this).attr("data-url"):path;
        var cancel = "<button class='btn btn-danger' style='float:right' id='cancelEditor' type='button'>Cancel</button>";
        var save = "<button class='btn btn-primary' style='float:right;margin-right:10px;' id='saveEditor' type='button'>Save</button>";
        var inputpath = "<input id='pathEditor' type='hidden' name='path'/>";
        var inputsave = "<input type='hidden' name='save' value='1'/>";
        var inputcolor = "<input type='hidden' name='color' value='"+color+"'/>";
        var inputbg = "<input type='hidden' name='bg' value='"+bg+"'/>";
        var alertmessage = "<label class='alert alert-info' id='alertmessage' style='display:none;position: absolute;right: 50px;top: 30px;'></label>";
        var textarea = "<textarea id='textareaEditor' name='text' spellcheck='false' style='width:100%;height:100vh;color:"+color+";background:"+bg+"'></textarea>";
        var form = "<form id='formEditor' action='saveFile.php' method='POST'>";
        var container = "<div id='containerTextEditor' style='width:100%;height:100%;padding:20px;color:"+color+";background:"+bg+";position:fixed;z-index:1'>";
        container += cancel;
        container += save;
        container += alertmessage;
        container += form;
        container += inputpath;
        container += inputsave;
        container += inputcolor;
        container += inputbg;
        container += textarea;
        container += '</form>';
        container += "</div>";
        addLoading("Mohon Tunggu");
        $.ajax({
            type:"get",
            url:url+"/readcontent.php?path="+path,
            success:function(data){
                removeLoading();
                $("#textareaEditor").val(data);
            }
        }).fail(function(){
            removeLoading();
            alert("Cant Connect Server");
        });
        if($("#containerTextEditor").length==0){
            $("body").prepend(container);
            $("#textareaEditor").focus();
            $("#pathEditor").val(path);
        }
    })
    HTMLTextAreaElement.prototype.setCaretPosition = function (start, end) {    //change the caret position of the textarea
        end = typeof end !== 'undefined' ? end : start;
        
        this.selectionStart = start;
        this.selectionEnd = end;
        this.focus();
    };
    
    HTMLTextAreaElement.prototype.hasSelection = function () { //if the textarea has selection then return true
        if (this.selectionStart == this.selectionEnd) {
            return false;
        } else {
            return true;
        }
    };
    
    HTMLTextAreaElement.prototype.isMultilineSelection = function() {
        var re = new RegExp('(\n)', "g");
        return (this.value.substring(this.selectionStart, this.selectionEnd).match(re)||[]).length > 0 ? true : false;
    };

    // button cancel
    $("body").on("click","#cancelEditor",function(){
        $("#containerTextEditor").remove();

    })
    // button save
    $("body").on("click","#saveEditor",function(){
        var frm = $("#formEditor");
        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize(),
            success: function (data) {
                showalert("Saved");
            },
            error: function (data) {
                showalert("Cant Saved");
            },
        });

    })

    function showalert(info){
        $("#alertmessage").text(info).show();
        setTimeout(function(){
            $("#alertmessage").hide();
        },1000);
    }
    
    $("body").on("keydown","#textareaEditor",function(e){
        
        
        // start save file
		if (e.ctrlKey && e.which == 83 ) {
            e.preventDefault();

            var frm = $("#formEditor");
            $.ajax({
                type: frm.attr('method'),
                url: frm.attr('action'),
                data: frm.serialize(),
                success: function (data) {
                    showalert("Saved");
                },
                error: function (data) {
                    showalert("Cant Saved");
                },
            });
        }
        // end save file

        // if (e.ctrlKey && e.altKey && e.which == 87 ) {
        //     $("#containerTextEditor").remove();
        // }

        // start cancel file or close file if not change
        if (e.ctrlKey && e.altKey && e.which == 87 ) {
            e.preventDefault();
            $("#containerTextEditor").remove();
        }
        // end start cancel file or close file if not change


        if(e.which == 9 && e.shiftKey){
            e.preventDefault();
            var tabString = "    ";
            var start = this.selectionStart;
            var end = this.selectionEnd;
            var target = e.target;
            var selectionStart = target.selectionStart;
            var selectionEnd = target.selectionEnd;
            var text = $(this).val();
            lineChar = -1;
            for(i=0;i<=this.selectionStart;i++){
                if(text[i]=="\n"){
                    lineChar = i;
                }
            }
            i = lineChar;
            lineChar++;
            j = lineChar;
            var l = 5;
            var endTab = j;
            while(text[j]==" "||text[j]=="\t"){
                if(l==0){
                    break;
                }

                if(text[j]=="\t"){
                    j++;
                    break;
                }
                l--;
                j++;
                endTab = j;
            }
            if(text[endTab]=="	"){
                j++;
                endTab++;
            }

            
            target.value = target.value.substring(0, lineChar) +  target.value.substring(endTab,  target.value.length);
            console.log("j-i",endTab-lineChar);
            if(endTab-lineChar<=1){
                if(text[lineChar+1]=="	"){
                    target.setCaretPosition(lineChar+1, lineChar+1);
                }else{
                    target.setCaretPosition(lineChar, lineChar);
                }
            }else{
                target.setCaretPosition(endTab, endTab);
            }
        }

        else if (e.which == 9) {
            e.preventDefault();

            var start = this.selectionStart;
            var end = this.selectionEnd;
            target = $(this);
            // set textarea value to: text before caret + tab + text after caret
            target.val(target.val().substring(0, start)
                        + "\t"
                        + target.val().substring(end));
        
            // put caret at right position again
            this.selectionStart =
            this.selectionEnd = start + 1;
        }
    })
})