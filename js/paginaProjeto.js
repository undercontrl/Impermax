// Função para carregar projetos do banco de dados
async function carregarProjetos() {
    const gridProjetos = document.getElementById('grid-projetos');
    
    try {
        const response = await fetch('backend/api/pagina-projeto');
        const resultado = await response.json();
        
        if (resultado.status === 'success' && resultado.data.length > 0) {
            gridProjetos.innerHTML = '';
            
            resultado.data.forEach(projeto => {
                const card = criarCardProjeto(projeto);
                gridProjetos.innerHTML += card;
            });
        } else {
            // Nenhum projeto encontrado
            gridProjetos.innerHTML = `
                <div class="empty-projetos">
                    <i class="bi bi-folder2-open"></i>
                    <h3>Nenhum projeto disponível</h3>
                    <p>Ainda não há projetos cadastrados para exibição.</p>
                </div>
            `;
        }
    } catch (error) {
        console.error('Erro ao carregar projetos:', error);
        gridProjetos.innerHTML = `
            <div class="empty-projetos">
                <i class="bi bi-exclamation-triangle"></i>
                <h3>Erro ao carregar projetos</h3>
                <p>Não foi possível carregar os projetos. Tente novamente mais tarde.</p>
            </div>
        `;
    }
}

// Função para criar o HTML do card
function criarCardProjeto(projeto) {
    // Extrair primeira palavra do nome como badge (ou usar categoria se existir)
    const badge = projeto.nome_projeto.split(' ')[0];
    
    return `
        <div class="card-projeto">
            <figure>
                <img src="${projeto.imagem_url}" 
                     alt="${projeto.nome_projeto}" 
                     class="projeto-imagem"
                     onerror="this.src='https://images.unsplash.com/photo-1581094271901-8022df4466f9?w=800'">
                <figcaption class="figcaption-projeto">
                    <h3 class="titulo-projeto">${projeto.nome_projeto}</h3>
                    <p class="texto-interno-projeto">${projeto.descricao_projeto}</p>
                </figcaption>
            </figure>
        </div>
    `;
}

// Carregar projetos quando a página carregar
document.addEventListener('DOMContentLoaded', carregarProjetos);
