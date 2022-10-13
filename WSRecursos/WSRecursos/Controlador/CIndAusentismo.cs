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
    public class CIndAusentismo
    {
        public List<EIndAusentismo> Listar_IndAusentismo(SqlConnection con)
        {
            List<EIndAusentismo> lEIndAusentismo = null;
            SqlCommand cmd = new SqlCommand("ASP_INDAUSENTISMO", con);
            cmd.CommandType = CommandType.StoredProcedure;
            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEIndAusentismo = new List<EIndAusentismo>();

                EIndAusentismo obEIndAusentismo = null;
                while (drd.Read())
                {
                    obEIndAusentismo = new EIndAusentismo();
                    obEIndAusentismo.i_anhio = drd["i_anhio"].ToString();
                    obEIndAusentismo.v_mes = drd["v_mes"].ToString();
                    obEIndAusentismo.v_periodo = drd["v_periodo"].ToString();
                    obEIndAusentismo.a_remunerado_dia = drd["a_remunerado_dia"].ToString();
                    obEIndAusentismo.b_no_remunerado_dia = drd["b_no_remunerado_dia"].ToString();
                    obEIndAusentismo.c_remunerado_persona = drd["c_remunerado_persona"].ToString();
                    obEIndAusentismo.d_no_remunerado_persona = drd["d_no_remunerado_persona"].ToString();
                    obEIndAusentismo.e_dotacion = drd["e_dotacion"].ToString();
                    obEIndAusentismo.f_porc_remunerado = drd["f_porc_remunerado"].ToString();
                    obEIndAusentismo.g_porc_no_remunerado = drd["g_porc_no_remunerado"].ToString();
                    lEIndAusentismo.Add(obEIndAusentismo);
                }
                drd.Close();
            }

            return (lEIndAusentismo);
        }
    }
}