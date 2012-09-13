"--------------------< Project >-----------------
" Project Vim Set
"------------------------------------------------


"--------------------- total config ---------------------

" Project root *
let s:PJRoot = expand('<sfile>:p:h')
if has('win32')
    let s:PJRoot = s:PJRoot . '\'
else
    let s:PJRoot = s:PJRoot . '/'
endif

"debugger
"echo s:PJRoot

" Sync config
let s:server = '192.168.8.9'
let s:path   = '/mnt/bak/dev/frontend/'
let s:username = 'bjserver'
let s:password = 'bjserver'
let s:port     = 22


let s:TagGenCmd = 'ctags --langmap=php:+.html.htm,-.js --extra=+q --fields=+iaS --php-kinds=-jv -RV ' . s:PJRoot . '*'


" Other config map hotkey * (default)
let s:ToTargetFile  = 'F'
let s:TagGen        = '\<space>'
let s:ToRoot        = '\'
let s:ToPage        = '\p'
let s:ToController  = '\c'
"let s:ToSystem      = '\s'
let s:ToService     = '\se'
let s:ToJs          = '\j'
let s:ToCss         = '\cs'
let s:ToVar         = '\v'
let s:ToReference   = 'M'
let s:ToCurrentPresenter  = '%p'
"let s:ToCurrentJs          = '%j'
"let s:ToCurrentHtml        = '%h'

let s:ToModuleHtm   = '%h'
let s:ToModuleCss   = '%c'
let s:ToModuleJS    = '%j'


" TODO Show alert ( display dir exist msg, 0: don't show, 1: show )
let s:ShowAlert     = 0


" Tmp var *
let g:MyTargetFilePath = ''

"--------------------- Functions --------------------"{{{
function! s:Slash(str)
    return substitute(a:str, '\', '/', 'g')
endfunction


function! s:BackSlash(str)
    return substitute(a:str, '/', '\', 'g')
endfunction

function! s:Alert(str)
    if exists('s:ShowAlert') && s:ShowAlert != ''
        echo a:str
    endif
endfunction

function! s:AlertERR(str)
    if exists('s:ShowAlert') && s:ShowAlert != ''
        echoerr a:str
    endif
endfunction

function! g:PJGoToModule(PJRoot, type)

    let moduleName  = expand('<cfile>:r')
    let viewRoot    = a:PJRoot . 'protected/views/'

    "echo finddir(moduleName, viewRoot)

    if finddir(moduleName, viewRoot) == ''
        call mkdir(viewRoot . moduleName, 'p')
    endif

    let filepath = viewRoot . moduleName

    let filename = moduleName . '.' . a:type
    exec ':tabedit ' . filepath . '/' . filename

endfunction



"sync file funciton
function! s:Sync_file()

    if g:MyTargetFilePath == ''
        echoerr 'Nothing can be sync!'
        return
    endif

    write
    let s:from = expand('%:p')
    let s:to   = ((strpart(s:path, strlen(s:path)-1) == '/') ? (s:path) : (s:path . '/')) . g:MyTargetFilePath

    let cmd = 'pscp -P '.s:port.' -pw '.s:password.' '.s:from.' '.s:username.'@'.s:server.':'.s:to
    "echo cmd
    echo s:from . '	-->	' . s:to
    echo system(cmd)
endfunction


"auto add Command
function! s:Trigger(funname)
    let s:root = s:Slash(s:PJRoot)
    let s:fullFilePath = s:Slash(expand('%:p'))
    let s:dir = matchstr(s:fullFilePath, s:root)
    if strlen(s:dir) > 0
        let g:MyTargetFilePath = strpart(s:fullFilePath, strlen(s:dir))

        call s:OtherConfig()

        if exists('s:server') && s:server != ''
            if a:funname == 'Sync'
                command! W call s:Sync_file()
            else
                command! WQ call s:Sync_file()
                quit
            endif
        endif
    endif
    unlet s:root
    unlet s:fullFilePath
    unlet s:dir
endfunction


" Jump to reference
function! g:PJGoToTag()
    let keyword = expand('<cword>')
    let taglist = taglist(keyword)

    if empty(taglist)
        echo 'tag not found: ' . keyword
        return
    endif

    let filename = taglist[0]['filename']

    "debugger
    "echo 'tabnew ' . filename
    "echo 'tag ' . keyword

    exec 'tabnew ' . filename
    exec 'tag ' . keyword
endfunction


function! g:TagGen(PJRoot, TagGenCmd)
    let pwd = getcwd()
    exec 'cd '. a:PJRoot
    call delete(a:PJRoot."tags")

    " debugger
    "echo '!'.a:TagGenCmd
    "echo 'cd '. pwd

    exec '!'.a:TagGenCmd
    exec 'cd '. pwd
endfunction

"}}}

"--------------------- tirgger --------------------"{{{
"restart webctl
autocmd BufEnter * call s:Trigger('Sync')
"}}}

"--------------------- Other config --------------------"{{{
function! s:OtherConfig()

    if &filetype == 'html' || &filetype == 'xhtml'
        set filetype=php
    endif

    " redefind path
    let &path = '.'
    if finddir('views', s:PJRoot . 'protected') != ''
        exec 'set path+=' . s:Slash(s:PJRoot)
        exec 'set path+=' . s:Slash(s:PJRoot . 'protected\views\')
    endif

    "hotkey mapping
    
    " tags generation
    if exists('s:TagGen') && s:TagGen != ''
        exec 'nmap '.s:TagGen." :call g:TagGen('".s:PJRoot."','".s:TagGenCmd."')<CR>"
    endif

    " to Root
    if exists('s:ToRoot') && s:ToRoot != ''
        exec 'nmap '.s:ToRoot.' :NERDTree '.s:PJRoot.'<CR>'
    endif

    " to Page
    if exists('s:ToPage') && s:ToPage != ''
        if finddir('views', s:PJRoot . 'protected') != ''
            exec 'nmap '.s:ToPage.' :NERDTree '.s:PJRoot.'protected/views/<CR>'
        else
            call s:AlertERR("Page dir not found!")
        endif
    endif

    " to Controller
    if exists('s:ToCurrentPresenter') && s:ToCurrentPresenter != ''
        if finddir('presenters', s:PJRoot . 'protected/') != ''
            let filename = substitute(expand('%:t:r'), '\w*', '\u&', 'g')
            exec 'nmap '.s:ToCurrentPresenter.' :tabnew '.s:PJRoot.'protected/presenters/'.filename.'Presenter.php<CR>'
        endif
    endif

    " to System
    "if exists('s:ToSystem') && s:ToSystem != ''
    "    if finddir('system', s:PJRoot) != ''
    "        exec 'nmap '.s:ToSystem.' :NERDTree '.s:PJRoot.'system/<CR>'
    "    else
    "        call s:AlertERR("System dir not found!")
    "    endif
    "endif

    " to Service
    if exists('s:ToService') && s:ToService != ''
        if finddir('services', s:PJRoot. 'protected/views') != ''
            exec 'nmap '.s:ToService.' :NERDTree '.s:PJRoot.'protected/views/services/<CR>'
        else
            call s:AlertERR("Services dir not found!")
        endif
    endif

    " to Javascript
    if exists('s:ToJs') && s:ToJs != ''
        if finddir('assets', s:PJRoot) != ''
            exec 'nmap '.s:ToJs.' :NERDTree '.s:PJRoot.'assets/<CR>'
        else
            call s:AlertERR("Javascript dir not found!")
        endif
    endif

    " to Css
    if exists('s:ToCss') && s:ToCss != ''
        if finddir('css', s:PJRoot) != ''
            exec 'nmap '.s:ToCss.' :NERDTree '.s:PJRoot.'css/<CR>'
        else
            call s:AlertERR("Css dir not found!")
        endif
    endif

    " to Var
    if exists('s:ToVar') && s:ToVar != ''
        if finddir('var', s:PJRoot) != ''
            exec 'nmap '.s:ToVar.' :NERDTree '.s:PJRoot.'var/<CR>'
        else
            call s:AlertERR("Var dir not found!")
        endif
    endif

    " to Module
    if exists('s:ToReference') && s:ToReference != ''
        exec 'nmap '.s:ToReference.' :call g:PJGoToTag()<CR>'
    endif

    " to tabnew File
    if exists('s:ToTargetFile') && s:ToTargetFile != ''
        exec 'nmap '.s:ToTargetFile.' <C-W>gf'
    endif

    " to Current Controller
    if exists('s:ToCurrentController') && s:ToCurrentController != ''
        if finddir('controllers', s:PJRoot . 'protected/') != ''
            let file = expand('%:t:r')
            exec 'nmap '.s:ToCurrentController.' :tabnew '.s:PJRoot.'protected/controllers/'.file.'Controller.php<CR>'
        endif
    endif

    " to Current HTML
    if exists('s:ToCurrentHtml') && s:ToCurrentHtml != ''
        if finddir('controllers', s:PJRoot . 'protected/') != ''
            let file = substitute(expand('%:t:r'), 'Controller', '', 'g')
            exec 'nmap '.s:ToCurrentHtml.' :tabnew '.s:PJRoot.'protected/views/pages/'.file.'.html<CR>'
        endif
    endif

    " to Current Javascript
    if exists('s:ToCurrentJs') && s:ToCurrentJs != ''
        if finddir('assets', s:PJRoot) != ''
            let file = substitute(expand('%:t:r'), 'Controller', '', 'g')
            exec 'nmap '.s:ToCurrentJs.' :tabnew '.s:PJRoot.'assets/'.file.'.js<CR>'
        endif
    endif

    " to module htm
    if exists('s:ToModuleHtm') && s:ToModuleHtm != ''
        exec 'nmap ' . s:ToModuleHtm . " :call g:PJGoToModule('".s:PJRoot."', 'htm')<CR>"
    endif

    " to module css
    if exists('s:ToModuleCss') && s:ToModuleCss != ''
        exec 'nmap ' . s:ToModuleCss . " :call g:PJGoToModule('".s:PJRoot."', 'css')<CR>"
    endif

    " to module js
    if exists('s:ToModuleJS') && s:ToModuleJS != ''
        exec 'nmap ' . s:ToModuleJS . " :call g:PJGoToModule('".s:PJRoot."', 'js')<CR>"
    endif

endfunction
"}}}



