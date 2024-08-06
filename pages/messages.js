export default () => {
    const container = document.createElement('div');
    const template = `<div class="head-title">
    <div class="left">
        <h1>Mensagens</h1>
        <ul class="breadcrumb">
            <li>
                <a >Mensagens</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a class="active" >Painel</a>
            </li>
        </ul>
    </div>
 </div>`

    container.innerHTML = template;
    return container;
}