using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Collections.Specialized;
using System.Linq;
using System.Web;
using System.Data;
using System.Data.SqlClient;
using WSRecursos.Entity;

namespace WSRecursos.Controller
{
    public class CConsultarCronograma
    {
        public List<EConsultarCronograma> Listar_ConsultarCronograma(SqlConnection con, Int32 codigo)
        {
            List<EConsultarCronograma> lEConsultarCronograma = null;
            SqlCommand cmd = new SqlCommand("ASP_CONSULTAR_CRONOGRAMA", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@codigo", SqlDbType.Int).Value = codigo;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEConsultarCronograma = new List<EConsultarCronograma>();

                EConsultarCronograma obEConsultarCronograma = null;
                while (drd.Read())
                {
                    obEConsultarCronograma = new EConsultarCronograma();
                    obEConsultarCronograma.v_dni = drd["v_dni"].ToString();
                    obEConsultarCronograma.v_nombres = drd["v_nombres"].ToString();
                    obEConsultarCronograma.v_mes = drd["v_mes"].ToString();
                    obEConsultarCronograma.i_tipo = drd["i_tipo"].ToString();
                    obEConsultarCronograma.v_dias = drd["v_dias"].ToString();
                    obEConsultarCronograma.i_anhio = drd["i_anhio"].ToString();
                    lEConsultarCronograma.Add(obEConsultarCronograma);
                }
                drd.Close();
            }

            return (lEConsultarCronograma);
        }
    }
}