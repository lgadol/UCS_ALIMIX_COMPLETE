import React, { useState, useEffect } from 'react';
import "./styles.css";
import Main from '../template/main';
import { useNavigate, Link } from 'react-router-dom';
import axios from 'axios';
import imgCard from "../img/alimixcard.jpg";
import imgLogo from "../img/logo.png";


function Home() {
    const navigate = useNavigate();
    const [saldoAtual, setSaldoAtual] = useState(0);
    const [saldosMensais, setSaldosMensais] = useState([]);
    const [movimentacoes, setMovimentacoes] = useState([]);

    useEffect(() => {
        async function fetchData() {
            try {
                const response = await axios.get('http://localhost:5000/todasmovimentacoes');
                const movimentacoesData = response.data.movimentacoes;

                // Ordena as movimentações por data
                movimentacoesData.sort((a, b) => new Date(a.datahora.date) - new Date(b.datahora.date));
                setMovimentacoes(movimentacoesData);

                // Calcula os saldos mensais
                const grupos = agruparPorMes(movimentacoesData);
                const novosSaldosMensais = [];
                let totalEntrada = 0;
                let totalSaida = 0;

                Object.keys(grupos).forEach(mesAno => {
                    let entrada = 0;
                    let saida = 0;

                    grupos[mesAno].forEach(mov => {
                        const valor = mov.valor;
                        const tipoMovimentacaoNome = mov.categoria && mov.categoria.tipoMovimentacao ? mov.categoria.tipoMovimentacao.nome : '';

                        if (tipoMovimentacaoNome === 'Entrada') {
                            entrada += valor;
                            totalEntrada += valor;
                        } else if (tipoMovimentacaoNome === 'Saída') {
                            saida += valor;
                            totalSaida += valor;
                        }
                    });

                    const saldo = entrada - saida;
                    novosSaldosMensais.push({ mesAno, entrada, saida, saldo });
                });

                setSaldosMensais(novosSaldosMensais);
                setSaldoAtual(totalEntrada - totalSaida);
            } catch (error) {
                console.error('Erro ao buscar todas as movimentações', error);
            }
        }

        fetchData();
    }, []);

    function agruparPorMes(movimentacoes) {
        const grupos = {};

        movimentacoes.forEach(mov => {
            const data = new Date(mov.datahora.date);
            const mesAno = `${data.getMonth() + 1}-${data.getFullYear()}`;

            if (!grupos[mesAno]) {
                grupos[mesAno] = [];
            }

            grupos[mesAno].push(mov);
        });

        return grupos;
    }

    return (
        <Main>
            <div className='content container-fluid'>
                <div style={{ display: 'grid', justifyContent: 'center', gridTemplateColumns: '1fr 1fr 1fr' }}>
                    <div style={{ gridColumn: '1' }}>
                        <img src={imgLogo} alt="Logo" width="300" height="200" />
                    </div>
                    <div style={{ gridColumn: '2' }}>
                        <img src={imgCard} alt="Imagem do Cartão" width="300" height="200" />
                    </div>
                    <div className='content_button' style={{ display: 'flex', flexDirection: 'column' }}>
                        <Link to="/home">
                            <button className='home_button'>
                                Home
                            </button>
                        </Link>
                        <Link to="/movimentacao">
                            <button className='mov_button'>
                                Movimentações
                            </button>
                        </Link>
                    </div>
                </div>
                <hr />
                <h1 style={{ display: 'flex', justifyContent: 'center' }}>
                    Saldo Atual
                </h1>
                <div style={{ display: 'flex', justifyContent: 'center' }}>
                    <h2 style={{
                        borderColor: saldoAtual >= 0 ? 'green' : 'red',
                        backgroundColor: saldoAtual >= 0 ? 'lightgreen' : 'lightcoral',
                    }} >
                        {saldoAtual.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })}
                    </h2>
                </div>
            </div>
        </Main>

    )
}

export default Home;