<?php
/**
 * Plugin Name: Bloque Titulo y Descripcion
 * Description: Plugin de tipo bloque para Gutenberg que cambia el estilo del título según la categoría seleccionada.
 * Version: 1.0.0
 * Author: Israel Vazquez Campuzano
 * License: GPL2+
 */


// Enqueue los scripts y estilos necesarios para el bloque
function bloque_titulo_desc_enqueue_assets()
{
    // Verifica si estamos en el editor de Gutenberg 
    // Registra y encola el script del editor
    wp_register_script('bloque-titulo-desc-editor-script', plugins_url('assets/editor.js', __FILE__), array('wp-blocks', 'wp-element', 'wp-edit-post'), '1.0.0', true);
    wp_enqueue_script('bloque-titulo-desc-editor-script');
   

}
add_action('admin_enqueue_scripts', 'bloque_titulo_desc_enqueue_assets');

//Estilos para el front
function estilos_backgroun_color(){
    wp_enqueue_style('bloque-titulo-desc-editor-style', plugins_url('assets/editor.css', __FILE__));
}
add_action('wp_enqueue_scripts', 'estilos_backgroun_color');

// Registra el bloque personalizado
function bloque_titulo_desc_register_block()
{
    // Verifica si Gutenberg está activo
    if (function_exists('register_block_type')) {
        // Registra el bloque personalizado
        register_block_type(
            'bloque-titulo-desc/bloque',
            array(
                'editor_script' => 'bloque-titulo-desc-editor-script',
                'render_callback' => 'bloque_titulo_desc_render_block',
            )
        );
    }
}
add_action('init', 'bloque_titulo_desc_register_block');

// Renderiza el bloque personalizado
function bloque_titulo_desc_render_block($attributes)
{
    $categoria = get_the_category(); 

    // Verifica si estamos en una entrada o publicación
    if (is_singular()) {
        // Verifica si se seleccionó una categoría
        if (!empty($categoria)) { 
            // Obtiene la categoría principal 
            $categoria_main = 'categoria-' . $categoria[0]->slug;
            $titulo_class = $categoria_main;
        }else{
            $titulo_class = 'default-style';
        }
    } else {
        // Estilo predeterminado para páginas
        $titulo_class = 'default-style';
    }

    ob_start();
    ?>
    <div class="fondo <?php echo esc_attr($titulo_class); ?>">
        <h2 class="<?php echo esc_attr($titulo_class); ?>"><?php echo esc_html($attributes['title']); ?></h2>
        <p>
            <?php echo esc_html($attributes['description']); ?>
        </p>
    </div>
    <?php
    return ob_get_clean();
}