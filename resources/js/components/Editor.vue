<template>
    <div>
        <DxHtmlEditor
            v-model="modelValue"
            @update:modelValue="changeData"
            :height="height"
        >
            <DxMediaResizing :enabled="true"/>
            <DxImageUpload
                :tabs="currentTabs"
                file-upload-mode="base64"
            />
            <DxToolbar :multiline="isMultiline">
                <DxItem name="undo"/>
                <DxItem name="redo"/>
                <DxItem name="separator"/>
                <DxItem
                    :accepted-values="sizeValues"
                    name="size"
                />
                <DxItem
                    :accepted-values="fontValues"
                    name="font"
                />
                <DxItem name="separator"/>
                <DxItem name="bold"/>
                <DxItem name="italic"/>
                <DxItem name="strike"/>
                <DxItem name="underline"/>
                <DxItem name="separator"/>
                <DxItem name="alignLeft"/>
                <DxItem name="alignCenter"/>
                <DxItem name="alignRight"/>
                <DxItem name="alignJustify"/>
                <DxItem name="separator"/>
                <DxItem name="orderedList"/>
                <DxItem name="bulletList"/>
                <DxItem name="separator"/>
                <DxItem
                    :accepted-values="headerValues"
                    name="header"
                />
                <DxItem name="separator"/>
                <DxItem name="color"/>
                <DxItem name="background"/>
                <DxItem name="separator"/>
                <DxItem name="link"/>
                <DxItem name="image"/>
                <DxItem name="separator"/>
                <DxItem name="clear"/>
                <DxItem name="codeBlock"/>
                <DxItem name="blockquote"/>
                <DxItem name="separator"/>
                <DxItem name="insertTable"/>
                <DxItem name="deleteTable"/>
                <DxItem name="insertRowAbove"/>
                <DxItem name="insertRowBelow"/>
                <DxItem name="deleteRow"/>
                <DxItem name="insertColumnLeft"/>
                <DxItem name="insertColumnRight"/>
                <DxItem name="deleteColumn"/>
            </DxToolbar>
        </DxHtmlEditor>
    </div>
</template>

<script setup>
import {ref} from "vue"
import {
    DxHtmlEditor,
    DxToolbar,
    DxMediaResizing,
    DxImageUpload,
    DxItem,
} from 'devextreme-vue/html-editor';
import {
    DxCheckBox,
} from 'devextreme-vue/check-box';
import {
    DxSelectBox,
} from 'devextreme-vue/select-box';
import { markup, tabs } from './data.js';

const props = defineProps({
    modelValue:String,
    height:String,
    isMultiline :{
        type:Boolean,
        default:false
    }
})




    const sizeValues = ['8pt', '10pt', '12pt', '14pt', '18pt', '24pt', '36pt', '40pt', '48pt']
    const fontValues = ['Arial', 'Courier New', 'Georgia', 'Impact', 'Lucida Console', 'Tahoma', 'Times New Roman', 'Verdana']
    const headerValues = [false, 1, 2, 3, 4, 5]
    const currentTabs = ['file', 'url'] //tabs[2].value,
    // const isMultiline = ref(props.isMultiline);



    const modelValue = ref(props.modelValue)
    const emit = defineEmits(['update:modelValue'])
    const changeData = (event) =>{
        emit('update:modelValue', event)
    }


</script>

<style>
/*.dx-quill-container{*/
/*    min-height: 400px;*/
/*}*/
.dx-htmleditor-content img {
    vertical-align: middle;
    padding-right: 10px;
}

.dx-htmleditor-content table {
    width: 50%;
}

.options {
    padding: 20px;
    background-color: rgba(191, 191, 191, 0.15);
    margin-top: 20px;
}

.caption {
    font-size: 18px;
    font-weight: 500;
}

.option {
    margin-top: 10px;
    display: inline-block;
    margin-right: 40px;
}

.option > .dx-selectbox,
.option > .label {
    display: inline-block;
    vertical-align: middle;
}

.option > .label {
    margin-right: 10px;
}
</style>
