const RUTA_IMAGENES = '/uploads/images_blogs_entrities/';
const TEMPLATE_ENTRY_PREVIEW = '<h3 class="text-center">{TITULO}</h3><img src="'+RUTA_IMAGENES+'{IMAGEN}" class="img-thumbnail mx-auto d-block" style="max-width:60%" /><strong>{AUTOR}</strong>/<span>{FECHA}</span><p>{TEXTO}</p><a class="text-danger" href="/ver-entrada/{ID}" title="Ver entrada completa">Ver todo</a>';

function view_entry_preview(element) {
    const $this = $(element);
    
    let space_entry_preview = $("#space-entry-preview");
    space_entry_preview.html('<div class="alert alert-info">Procesando....</div>');
    
    const image = $this.attr('entry_image') > '' ? $this.attr('entry_image') : 'empty.png';
    let Data = {
        TITULO: $this.attr('entry_title'),
        IMAGEN: image,
        AUTOR: $this.attr('entry_autor'),
        FECHA: $this.attr('entry_date'),
        TEXTO: $this.attr('entry_text').substr(0, 255)+'...',
        ID: $this.attr('entry_id')
    };

    let view = TEMPLATE_ENTRY_PREVIEW;
    for (const key in Data) {
        let keyr = '{'+key+'}';
        view = view.replace(keyr, Data[key]);
    }

    space_entry_preview.html(view);
}
// view_entry_preview(document.getElementsByClassName('view-entry-preview')[0]);