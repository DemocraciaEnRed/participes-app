<template>
  <div class="editor">
    <editor-menu-bubble
      class="menububble"
      :editor="editor"
      @hide="hideLinkMenu"
      v-slot="{ commands, isActive, getMarkAttrs, menu }"
    >
      <div
        class="menububble"
        :class="{ 'is-active': menu.isActive }"
        :style="`left: ${menu.left}px; bottom: ${menu.bottom}px;`"
      >
        <form class="menububble__form" v-if="linkMenuIsActive">
          <input
            class="menububble__input"
            type="text"
            style="font-size: 12px;"
            v-model="linkUrl"
            placeholder="https://"
            ref="linkInput"
            @keydown.enter="setLinkUrl(commands.link, linkUrl)"
            @keydown.esc="hideLinkMenu"
          />
          <a class="menububble__button" @click="setLinkUrl(commands.link, null)">
            <i class="fas fa-times text-white"></i>
          </a>
        </form>

        <template v-else>
          <span
            class="menububble__button"
            :class="{ 'is-active': isActive.bold() }"
            @click="commands.bold"
          >
            <i class="fas fa-bold fa-fw"></i>
          </span>

          <span
            class="menububble__button"
            :class="{ 'is-active': isActive.italic() }"
            @click="commands.italic"
          >
            <i class="fas fa-italic fa-fw"></i>
          </span>

          <span
            class="menububble__button"
            :class="{ 'is-active': isActive.underline() }"
            @click="commands.underline"
          >
            <i class="fas fa-underline fa-fw"></i>
          </span>
          <span
            class="menububble__button"
            :class="{ 'is-active': isActive.link() }"
            @click="showLinkMenu(getMarkAttrs('link'))"
          >
            <span style="font-size:10px;">{{ isActive.link() ? 'Cambiar ' : ''}}</span>
            <i class="fas fa-link fa-fw"></i>
          </span>
        </template>
      </div>
    </editor-menu-bubble>
    <editor-content class="tiptap-editor-content" :editor="editor" />
  	<small class="form-text text-muted"><span class="text-info"><i class="far fa-lightbulb"></i>&nbsp; ¡Este campo soporta formato!</span> Para agregar formato al texto, seleccione la porción a aplicar formato y un pop-up aparecerá sobre el mismo con las opciones disponibles.</small>
    <input type="hidden" :name="name" :value="json">
  </div>
</template>

<script>
import { Editor, EditorContent, EditorMenuBubble } from "tiptap";
import { Bold, Italic, Underline, Link } from "tiptap-extensions";

export default {
  props: {
    name: {
      type: String,
      required: true,
    },
    disabled: {
      type: Boolean,
      default: false
    },
    content: {
      type: Object,
      default: () => ({
        type: "doc",
        content: [
          {
            type: "paragraph",
            content: [
              {
                type: "text",
                text: "Este es un parrafo. Puede aplicarle formato, ya sea en "
              },
              {
                type: "text",
                marks: [
                  {
                    type: "bold"
                  }
                ],
                text: "negrita"
              },
              {
                type: "text",
                text: " o tambien en "
              },
              {
                type: "text",
                marks: [
                  {
                    type: "italic"
                  }
                ],
                text: "cursiva"
              },
              {
                type: "text",
                text: "."
              }
            ]
          },
          {
            type: "paragraph",
            content: [
              {
                type: "text",
                text:
                  "Puede crear multiples parrafos y tambien links. ¡Recuerde borrar estos parrafos, funcionan como default!"
              }
            ]
          },
        ]
      }),
    }
  },
  components: {
    EditorContent,
    EditorMenuBubble
  },
  data() {
    return {
      json: JSON.stringify(this.content),
      html: '<p>Error</p>',
      editor: new Editor({
        editable: !this.disabled,
        extensions: [new Link(), new Bold(), new Italic(), new Underline()],
        content: this.content,
        onUpdate: ({ getJSON, getHTML }) => {
          this.json = JSON.stringify(getJSON())
          this.html = getHTML()
        },
      }),
      linkUrl: null,
      linkMenuIsActive: false
    };
  },
  beforeDestroy() {
    this.editor.destroy();
  },
  methods: {
    showLinkMenu(attrs) {
      this.linkUrl = attrs.href;
      this.linkMenuIsActive = true;
      this.$nextTick(() => {
        this.$refs.linkInput.focus();
      });
    },
    hideLinkMenu() {
      this.linkUrl = null;
      this.linkMenuIsActive = false;
    },
    setLinkUrl(command, url) {
      command({ href: url });
      this.hideLinkMenu();
    }
  }
};
</script>
