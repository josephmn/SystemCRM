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
    public class CIndAusentismoxArea
    {
        public List<EIndAusentismoxArea> Listar_IndAusentismoxArea(SqlConnection con)
        {
            List<EIndAusentismoxArea> lEIndAusentismoxArea = null;
            SqlCommand cmd = new SqlCommand("ASP_INDAUSENTISMOXAREA", con);
            cmd.CommandType = CommandType.StoredProcedure;
            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEIndAusentismoxArea = new List<EIndAusentismoxArea>();

                EIndAusentismoxArea obEIndAusentismoxArea = null;
                while (drd.Read())
                {
                    obEIndAusentismoxArea = new EIndAusentismoxArea();
                    obEIndAusentismoxArea.v_descripcion = drd["v_descripcion"].ToString();
                    obEIndAusentismoxArea.a_remunerado_dia = drd["a_remunerado_dia"].ToString();
                    obEIndAusentismoxArea.b_no_remunerado_dia = drd["b_no_remunerado_dia"].ToString();
                    obEIndAusentismoxArea.c_remunerado_persona = drd["c_remunerado_persona"].ToString();
                    obEIndAusentismoxArea.d_no_remunerado_persona = drd["d_no_remunerado_persona"].ToString();
                    obEIndAusentismoxArea.e_dotacion = drd["e_dotacion"].ToString();
                    obEIndAusentismoxArea.f_porc_remunerado = drd["f_porc_remunerado"].ToString();
                    obEIndAusentismoxArea.g_porc_no_remunerado = drd["g_porc_no_remunerado"].ToString();
                    lEIndAusentismoxArea.Add(obEIndAusentismoxArea);
                }
                drd.Close();
            }

            return (lEIndAusentismoxArea);
        }
    }
}