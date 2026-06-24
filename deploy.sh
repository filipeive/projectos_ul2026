#!/bin/bash
# ╔═══════════════════════════════════════════════════════╗
# ║  UniLicungo TechHub — One-Click Deploy Script        ║
# ║  Autor: Filipe dos Santos                            ║
# ║  Servidor: 146.235.224.99 (Oracle Cloud)             ║
# ╚═══════════════════════════════════════════════════════╝

set -e

# Colors
GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color
BOLD='\033[1m'

# Config
REMOTE_USER="ubuntu"
REMOTE_HOST="146.235.224.99"
REMOTE_PATH="/var/www/html/projectos_UL"
BRANCH="master"
REPO_ORIGIN="origin"

echo ""
echo -e "${BLUE}╔═══════════════════════════════════════════════════╗${NC}"
echo -e "${BLUE}║${NC}  ${BOLD}🚀 UniLicungo TechHub — Deploy Pipeline${NC}         ${BLUE}║${NC}"
echo -e "${BLUE}╚═══════════════════════════════════════════════════╝${NC}"
echo ""

# Step 1: Check for uncommitted changes
echo -e "${YELLOW}[1/6]${NC} Verificando alterações locais..."
if [[ -n $(git status --porcelain) ]]; then
    echo -e "${YELLOW}  ⚠  Existem alterações não comitadas:${NC}"
    git status --short
    echo ""
    read -p "  Deseja fazer commit automático? (s/n): " DO_COMMIT
    if [[ "$DO_COMMIT" == "s" || "$DO_COMMIT" == "S" ]]; then
        read -p "  Mensagem do commit: " COMMIT_MSG
        git add -A
        git commit -m "${COMMIT_MSG:-'deploy: auto-commit via deploy.sh'}"
        echo -e "${GREEN}  ✓ Commit feito com sucesso${NC}"
    else
        echo -e "${RED}  ✗ Deploy cancelado. Faça commit primeiro.${NC}"
        exit 1
    fi
else
    echo -e "${GREEN}  ✓ Sem alterações pendentes${NC}"
fi

# Step 2: Ensure we are on master
echo -e "${YELLOW}[2/6]${NC} Verificando branch..."
CURRENT_BRANCH=$(git branch --show-current)
if [[ "$CURRENT_BRANCH" != "$BRANCH" ]]; then
    echo -e "${YELLOW}  ⚠  Branch actual: ${CURRENT_BRANCH}. A mudar para ${BRANCH}...${NC}"
    git checkout "$BRANCH"
fi
echo -e "${GREEN}  ✓ Branch: ${BRANCH}${NC}"

# Step 3: Push to GitHub
echo -e "${YELLOW}[3/6]${NC} Enviando para GitHub..."
git push "$REPO_ORIGIN" "$BRANCH" 2>&1 | tail -1
echo -e "${GREEN}  ✓ GitHub actualizado${NC}"

# Step 4: Pull on production server
echo -e "${YELLOW}[4/6]${NC} Fazendo pull no servidor de produção (${REMOTE_HOST})..."
ssh -o StrictHostKeyChecking=no -o ConnectTimeout=10 "${REMOTE_USER}@${REMOTE_HOST}" \
    "cd ${REMOTE_PATH} && sudo git pull origin ${BRANCH}" 2>&1 | tail -3
echo -e "${GREEN}  ✓ Código actualizado no servidor${NC}"

# Step 5: Clear Laravel caches
echo -e "${YELLOW}[5/6]${NC} Limpando caches do Laravel..."
ssh -o StrictHostKeyChecking=no "${REMOTE_USER}@${REMOTE_HOST}" \
    "cd ${REMOTE_PATH} && sudo php artisan config:clear && sudo php artisan view:clear && sudo php artisan cache:clear" 2>&1 | grep -oP 'INFO.*' || true
echo -e "${GREEN}  ✓ Caches limpos${NC}"

# Step 6: Set permissions
echo -e "${YELLOW}[6/6]${NC} Ajustando permissões..."
ssh -o StrictHostKeyChecking=no "${REMOTE_USER}@${REMOTE_HOST}" \
    "cd ${REMOTE_PATH} && sudo chown -R www-data:www-data storage bootstrap/cache && sudo chmod -R 775 storage bootstrap/cache" 2>&1
echo -e "${GREEN}  ✓ Permissões ajustadas${NC}"

# Done
echo ""
echo -e "${GREEN}╔═══════════════════════════════════════════════════╗${NC}"
echo -e "${GREEN}║${NC}  ${BOLD}✅ Deploy concluído com sucesso!${NC}                 ${GREEN}║${NC}"
echo -e "${GREEN}║${NC}                                                   ${GREEN}║${NC}"
echo -e "${GREEN}║${NC}  🌐 ${BLUE}http://146.235.224.99/projectos_ul/${NC}          ${GREEN}║${NC}"
echo -e "${GREEN}║${NC}  📅 $(date '+%d/%m/%Y às %H:%M:%S')                       ${GREEN}║${NC}"
echo -e "${GREEN}╚═══════════════════════════════════════════════════╝${NC}"
echo ""
