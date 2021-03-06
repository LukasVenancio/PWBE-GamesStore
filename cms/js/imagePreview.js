'use strict'

const loadImage = () =>{

    imagePreview('image-input', 'image-container')
}

const imagePreview = (idFile, idImage) =>{

    const file = document.getElementById(idFile).files[0]
    const preview = document.getElementById(idImage)
    const fileReader = new FileReader()

    if(file){
        fileReader.readAsDataURL(file)
        fileReader.onloadend = () => preview.src = fileReader.result
    }

}

document.getElementById('image-input').addEventListener('change', loadImage)