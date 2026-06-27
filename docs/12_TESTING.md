# 12 — Testing
> **AcademicHub** | Estratégia e Registo de Testes

---

## Princípio

> Nunca finalizar uma tarefa sem testar.
> O código que não é testado, não está concluído.

---

## Estado Atual dos Testes

| Tipo de Teste         | Estado    | Cobertura |
|-----------------------|-----------|-----------|
| Testes Unitários (PHPUnit) | ⚠️ Mínimo | ~5%  |
| Testes de Integração  | 🔲 Pendente | 0%   |
| Testes de UI (Browser)| Manual    | Parcial   |
| Testes de Acessibilidade | Manual | Parcial  |
| Testes de Performance | 🔲 Pendente | 0%   |

---

## Checklist de Testes Manuais por Feature

Sempre que uma nova funcionalidade for implementada, validar:

### Interface
- [ ] Desktop (>1024px) — Chrome, Firefox
- [ ] Tablet (768px–1024px)
- [ ] Mobile (<640px) — Chrome Mobile
- [ ] Dark Mode
- [ ] Light Mode
- [ ] Console JS sem erros
- [ ] Sem overflow horizontal

### Funcionalidade
- [ ] Fluxo principal funciona end-to-end
- [ ] Validações de formulário ativas
- [ ] Mensagens de erro claras para o utilizador
- [ ] Estados de carregamento (spinners, loading states)

### Acessibilidade
- [ ] Navegação por teclado (Tab, Enter, Escape)
- [ ] ARIA labels e roles corretos
- [ ] Contraste de cores suficiente (WCAG AA)
- [ ] Área de toque mínima 44px

### IA
- [ ] Resposta da IA dentro do tempo esperado (<10s)
- [ ] Proteção contra prompt injection
- [ ] Fallback em caso de erro da API

---

## Testes Automatizados (Planeado — v1.0)

### PHPUnit / Pest

```
tests/
├── Unit/
│   ├── AiControllerTest.php
│   ├── WorkspaceControllerTest.php
│   └── AfricaTalkingServiceTest.php
└── Feature/
    ├── PortalTest.php
    ├── AuthTest.php
    ├── WorkspaceTest.php
    └── AdminTest.php
```

### Casos de Teste Prioritários
1. **Auth:** Login com credenciais corretas e incorretas.
2. **Candidatura:** Submissão válida e inválida de candidatura.
3. **Workspace:** Criação e atualização de tarefa Kanban.
4. **IA:** Pedido de geração de ideia retorna JSON válido.
5. **SMS:** Gateway envia mensagem sem exceções.

---

## Comandos

```bash
# Executar todos os testes
php artisan test

# Executar testes específicos
php artisan test --filter WorkspaceTest

# Ver cobertura de código
php artisan test --coverage
```
