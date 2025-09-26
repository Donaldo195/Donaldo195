<!DOCTYPE html>
<html lang="PT-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Admissão - Universidade Pedagógica</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/main.css">
 
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container header-container">
           <a href="./index.php" class="logo">
                <img src="./assets/img/logo.jpeg" alt="Universidade Pedagógica">
            </a>    

            <nav class="desktop-menu">
                <li><a href="#" class="active"><i></i> Início</a></li>
                <li><a href="#"><i ></i>Cursos</a></li>
                <li><a href="./views/login.php"><i ></i>Admissões</a></li>
                <li><a href="#"><i ></i>Contactos</a></li>
            </nav>

            <div class="auth-buttons">
                <a href="./views/login.php" class="btn btn-outline"><i class="fas fa-user"></i> Portal do Candidato</a>
            </div>

            <button class="hamburguer">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </header>

    <!-- Mobile Menu -->
    <div class="overlay"></div>
    <div class="mobile-menu">
        <button class="close-menu">
            <i class="fas fa-times"></i>
        </button>
        <div class="mobile-menu-logo">
            <img src="./assets/img/logo.jpeg" alt="Universidade Pedagógica">
        </div>
        <ul class="mobile-nav">
            <li><a href="#"><i class="fas fa-home"></i> Início</a></li>
            <li><a href="#"><i class="fas fa-graduation-cap"></i> Cursos</a></li>
            <li><a href="#"><i class="fas fa-book-open"></i> Admissões</a></li>
            <li><a href="#"><i class="fas fa-envelope"></i> Contactos</a></li>
        </ul>
        <div class="mobile-auth">
            <a href="./views/login.php" class="btn btn-outline btn-sm"><i class="fas fa-user"></i> Portal do Candidato</a>
        </div>
    </div>

    <!-- Carousel -->
    <div class="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active" style="background-image: url('./assets/img/carosel1.jpeg');">
                <div class="carousel-content">
                    <h2>Admissões 2025/2026 Abertas</h2>
                    <p>Junte-se à principal instituição de ensino superior em Moçambique. Programas académicos de excelência, infraestrutura moderna e corpo docente qualificado.</p>
                    <a href="./views/cadastro.php" class="btn"><i class="fas fa-pencil-alt"></i> Candidatar-se Agora</a>
                </div>
            </div>
            <div class="carousel-item" style="background-image: url('https://images.unsplash.com/photo-1498243691581-b145c3f54a5a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1800&q=80');">
                <div class="carousel-content">
                    <h2>Excelência em Educação</h2>
                    <p>Formamos os líderes do amanhã com métodos pedagógicos inovadores e uma abordagem centrada no estudante.</p>
                </div>
            </div>
            <div class="carousel-item" style="background-image: url('https://www.startpage.com/av/proxy-image?piurl=https%3A%2F%2Fthf.bing.com%2Fth%2Fid%2FOIP.gfCnpHYpR3s7UxwgOTQNvAHaEK%3Fr%3D0%26cb%3Dthfc1%26pid%3DApi&sp=1756405399T0416d5c63f596b3165251c17b3a18b6be594186db914581fdc0324a1c5b1911e');">
                <div class="carousel-content">
                    <h2>Infraestrutura Moderna</h2>
                    <p>Salas de aula equipadas, laboratórios de última geração e bibliotecas com vasto acervo bibliográfico.</p>
                </div>
            </div>
        </div>
        <div class="carousel-nav">
            <!--<button class="carousel-prev"><i class="fas fa-chevron-left"></i></button>
            <button class="carousel-next"><i class="fas fa-chevron-right"></i></button>-->
        </div>
        <div class="carousel-controls">
            <div class="carousel-control active" data-index="0"></div>
            <div class="carousel-control" data-index="1"></div>
            <div class="carousel-control" data-index="2"></div>
        </div>
    </div>

    <!-- Processos Section -->
    <section class="processos">
        <div class="container">
            <h2 class="section-title">Processo de Admissão</h2>
            <p class="section-subtitle">Conheça as etapas necessárias para se candidatar aos nossos programas académicos e iniciar a sua jornada na Universidade Pedagógica.</p>
            <div class="processos-grid">
                <div class="processo-card">
                    <div class="card-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div class="card-content">
                        <h3>Requisitos de Candidatura</h3>
                        <p>Conheça os documentos necessários e pré-requisitos para o processo de candidatura aos nossos programas académicos de licenciatura e pós-graduação.</p>
                        <a href="#" class="btn btn-outline"><i class="fas fa-list"></i> Ver Detalhes</a>
                    </div>
                </div>

                <div class="processo-card">
                    <div class="card-icon">
                        <i class="far fa-calendar-alt"></i>
                    </div>
                    <div class="card-content">
                        <h3>Calendário Académico</h3>
                        <p>Consulte as datas importantes do processo de admissão, prazos de candidatura, período de exames de acesso e datas de início das aulas.</p>
                        <a href="#" class="btn btn-outline"><i class="fas fa-calendar"></i> Ver Calendário</a>
                    </div>
                </div>

                <div class="processo-card">
                    <div class="card-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="card-content">
                        <h3>Provas de Acesso</h3>
                        <p>Informações sobre os exames de acesso, conteúdos programáticos, datas de realização e materiais de preparação disponíveis para os candidatos.</p>
                        <a href="#" class="btn btn-outline"><i class="fas fa-book"></i> Saber Mais</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Cursos Section -->
    <section class="cursos">
        <div class="container">
            <h2 class="section-title">Programas Académicos</h2>
            <p class="section-subtitle">Explore nossa oferta formativa diversificada e encontre o programa que melhor se adequa aos seus objetivos profissionais e académicos.</p>
            <div class="cursos-grid">
                <div class="curso-card">
                    <div class="curso-image">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="curso-content">
                        <h3>Licenciatura em Ensino</h3>
                        <p>Formação de professores para o ensino primário e secundário com metodologias modernas de educação e práticas pedagógicas inovadoras.</p>
                        <a href="#" class="btn btn-outline"><i class="fas fa-info-circle"></i> Detalhes do Curso</a>
                        <div class="curso-meta">
                            <span><i class="far fa-clock"></i> 4 anos</span>
                            <span><i class="fas fa-graduation-cap"></i> Licenciatura</span>
                        </div>
                    </div>
                </div>

                <div class="curso-card">
                    <div class="curso-image">
                        <i class="fas fa-brain"></i>
                    </div>
                    <div class="curso-content">
                        <h3>Psicologia Educacional</h3>
                        <p>Compreensão dos processos de aprendizagem e desenvolvimento humano em contextos educativos, com enfoque na orientação vocacional.</p>
                        <a href="#" class="btn btn-outline"><i class="fas fa-info-circle"></i> Detalhes do Curso</a>
                        <div class="curso-meta">
                            <span><i class="far fa-clock"></i> 5 anos</span>
                            <span><i class="fas fa-graduation-cap"></i> Licenciatura</span>
                        </div>
                    </div>
                </div>

                <div class="curso-card">
                    <div class="curso-image">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <div class="curso-content">
                        <h3>Tecnologias de Educação</h3>
                        <p>Integração de tecnologias digitais em ambientes de ensino e aprendizagem, desenvolvimento de materiais educativos digitais e e-learning.</p>
                        <a href="#" class="btn btn-outline"><i class="fas fa-info-circle"></i> Detalhes do Curso</a>
                        <div class="curso-meta">
                            <span><i class="far fa-clock"></i> 4 anos</span>
                            <span><i class="fas fa-graduation-cap"></i> Licenciatura</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><br><br>

   
    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-container">
                <div class="footer-col">
                    <h3>Universidade Pedagógica</h3>
                    <p>Comprometida com a excelência no ensino, pesquisa e extensão comunitária na área da educação. Formamos profissionais qualificados para transformar a educação em Moçambique.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>

                <div class="footer-col">
                    <h3>Links Rápidos</h3>
                    <ul class="footer-links">
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Cursos e Programas</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Processo de Admissão</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Bolsas de Estudo</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Biblioteca Virtual</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Notícias e Eventos</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h3>Recursos</h3>
                    <ul class="footer-links">
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Portal do Estudante</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Portal do Professor</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Calendário Académico</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Moodle E-Learning</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Oportunidades de Carreira</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h3>Newsletter</h3>
                    <p>Subscreva à nossa newsletter para receber actualizações sobre admissões, eventos e novidades académicas.</p>
                    <form>
                        <div class="form-group">
                            <input type="email" placeholder="Seu endereço de email" required>
                        </div>
                        <button type="submit" class="btn btn-sm"><i class="fas fa-paper-plane"></i> Subscrever</button>
                    </form>
                </div>
            </div>

            <div class="copyright">
                <p>&copy; 2023 Universidade Pedagógica. Todos os direitos reservados. | Desenvolvido por <a href="#" style="color: var(--accent);">Departamento de Tecnologias de Informação</a></p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile Menu Toggle
        const hamburguer = document.querySelector('.hamburguer');
        const mobileMenu = document.querySelector('.mobile-menu');
        const overlay = document.querySelector('.overlay');
        const closeMenu = document.querySelector('.close-menu');

        hamburguer.addEventListener('click', () => {
            mobileMenu.classList.add('active');
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        });

        const closeMobileMenu = () => {
            mobileMenu.classList.remove('active');
            overlay.classList.remove('active');
            document.body.style.overflow = 'auto';
        };

        closeMenu.addEventListener('click', closeMobileMenu);
        overlay.addEventListener('click', closeMobileMenu);

        // Carousel Functionality
        const carouselItems = document.querySelectorAll('.carousel-item');
        const carouselControls = document.querySelectorAll('.carousel-control');
        const prevButton = document.querySelector('.carousel-prev');
        const nextButton = document.querySelector('.carousel-next');
        let currentIndex = 0;
        let carouselInterval;

        const showSlide = (index) => {
            carouselItems.forEach(item => item.classList.remove('active'));
            carouselControls.forEach(control => control.classList.remove('active'));
            
            carouselItems[index].classList.add('active');
            carouselControls[index].classList.add('active');
            currentIndex = index;
        };

        const nextSlide = () => {
            let nextIndex = (currentIndex + 1) % carouselItems.length;
            showSlide(nextIndex);
        };

        const prevSlide = () => {
            let prevIndex = (currentIndex - 1 + carouselItems.length) % carouselItems.length;
            showSlide(prevIndex);
        };

        // Add event listeners to controls
        carouselControls.forEach(control => {
            control.addEventListener('click', () => {
                let index = parseInt(control.getAttribute('data-index'));
                showSlide(index);
                resetCarouselInterval();
            });
        });

        prevButton.addEventListener('click', () => {
            prevSlide();
            resetCarouselInterval();
        });

        nextButton.addEventListener('click', () => {
            nextSlide();
            resetCarouselInterval();
        });

        // Auto advance carousel
        const startCarouselInterval = () => {
            carouselInterval = setInterval(nextSlide, 5000);
        };

        const resetCarouselInterval = () => {
            clearInterval(carouselInterval);
            startCarouselInterval();
        };

        startCarouselInterval();

        // Pause carousel on hover
        const carousel = document.querySelector('.carousel');
        carousel.addEventListener('mouseenter', () => {
            clearInterval(carouselInterval);
        });

        carousel.addEventListener('mouseleave', () => {
            startCarouselInterval();
        });

        // Form submission
        const contactForm = document.getElementById('contactForm');
        if (contactForm) {
            contactForm.addEventListener('submit', (e) => {
                e.preventDefault();
                // Here you would normally handle form submission to a server
                alert('Obrigado pela sua mensagem! Entraremos em contacto brevemente.');
                contactForm.reset();
            });
        }

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Animation on scroll
        const animateOnScroll = () => {
            const elements = document.querySelectorAll('.processo-card, .curso-card, .stat-item');
            
            elements.forEach(element => {
                const elementPosition = element.getBoundingClientRect().top;
                const screenPosition = window.innerHeight / 1.3;
                
                if (elementPosition < screenPosition) {
                    element.style.opacity = 1;
                    element.style.transform = 'translateY(0)';
                }
            });
        };

        // Initialize elements for animation
        document.querySelectorAll('.processo-card, .curso-card, .stat-item').forEach(element => {
            element.style.opacity = 0;
            element.style.transform = 'translateY(50px)';
            element.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        });

        window.addEventListener('scroll', animateOnScroll);
        // Trigger once on load
        window.addEventListener('load', animateOnScroll);
    </script>
</body>
</html>