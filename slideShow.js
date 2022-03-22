'use strict'

const db = [
    {
        id: 1, 
        descricao: "Jogo Marvel's Spider-Man: Miles Morales - PS4", 
        preco: 999.99, 
        parcelamento: 'ou 10x de 99.99 sem juros',
        imagem: './img/spider.webp'
    },
    {
        id: 2,  
        descricao: "Jogo The Last Of Us: Part II - PS4",   
        preco: 2500, 
        parcelamento: 'ou 10x de 250 sem juros',
        imagem: './img/theLastOfUs.webp'
    },
    {
        id: 3,  
        descricao: "Jogo God of War 4 - Playstation Hits - PS4",   
        preco: 350, 
        parcelamento: 'ou 10x de 35 sem juros',
        imagem: './img/godOfWar.jpg'
    },
    {
        id: 4,  
        descricao: "Jogo Red Dead Redemption 2 - PS4",   
        preco: 350, 
        parcelamento: 'ou 10x de 35 sem juros',
        imagem: './img/ReadDead.jpg'
    },
    {
        id: 5,  
        descricao: "Jogo FIFA 21 - PS4",   
        preco: 350, 
        parcelamento: 'ou 10x de 35 sem juros',
        imagem: './img/fifa.jpg'
    },
    {
        id: 6,  
        descricao: "Jogo Grand Theft Auto V - Premium Online Edition - PS4",   
        preco: 350, 
        parcelamento: 'ou 10x de 35 sem juros',
        imagem: './img/gta.jpg'
    }
]

const container = document.getElementById('destaques-container-cards')

const creatCard = (db) =>{
    
    const card = document.createElement('div')
    card.classList.add('destaques-cards')
    card.innerHTML = `
                <img src="${db.imagem}" alt="">
                <p class="destaques-cards-descricao">
                    ${db.descricao}
                </p>
                <p class="destaques-cards-preco">
                    R$ ${db.preco}
                </p>
                <p class="destaques-cards-parcelamento">
                    ${db.parcelamento}
                </p>`
               
    return card            
}

const loadCards = (db, container) =>{

    const cards = db.map(creatCard)
    container.replaceChildren(...cards)
}



//loadCards(db, container)