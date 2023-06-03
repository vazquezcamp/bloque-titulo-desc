wp.blocks.registerBlockType("bloque-titulo-desc/bloque", {
    title: "Bloque Titulo y Descripción", 
    category: "common",
    attributes: {
        title: {
            type: "string",
            default: "",
        },
        description: {
            type: "string",
            default: "",
        },
    },
    edit: function (props) {
        return wp.element.createElement(
            "div",
            { className: "fondo" },
            wp.element.createElement(
                "h2",
                null,
                wp.element.createElement(wp.components.TextControl, {
                    label: "Título",
                    value: props.attributes.title,
                    onChange: function (title) {
                        props.setAttributes({ title: title });
                    },
                    placeholder: "Ingrese el título",
                })
            ),
            wp.element.createElement(
                "p",
                null,
                wp.element.createElement(wp.blockEditor.RichText, {
                    label: "Descripción",
                    value: props.attributes.description,
                    onChange: function (description) {
                        props.setAttributes({ description: description });
                    },
                    placeholder: "Ingrese la descripción",
                })
            )
        );
    },
    save: function (props) {
        return wp.element.createElement(
            "div",
            { className: "fondo" },
            wp.element.createElement(
                "h2",
                { className: "default-style" },
                props.attributes.title
            ),
            wp.element.createElement("p", null, props.attributes.description)
        );
    },
});
