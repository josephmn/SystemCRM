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
    public class CIndAusentismoxCargo
    {
        public List<EIndAusentismoxCargo> Listar_IndAusentismoxCargo(SqlConnection con)
        {
            List<EIndAusentismoxCargo> lEIndAusentismoxCargo = null;
            SqlCommand cmd = new SqlCommand("ASP_INDAUSENTISMOXCARGO", con);
            cmd.CommandType = CommandType.StoredProcedure;
            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEIndAusentismoxCargo = new List<EIndAusentismoxCargo>();

                EIndAusentismoxCargo obEIndAusentismoxCargo = null;
                while (drd.Read())
                {
                    obEIndAusentismoxCargo = new EIndAusentismoxCargo();
                    obEIndAusentismoxCargo.v_descripcion = drd["v_descripcion"].ToString();
                    obEIndAusentismoxCargo.a_remunerado_dia = drd["a_remunerado_dia"].ToString();
                    obEIndAusentismoxCargo.b_no_remunerado_dia = drd["b_no_remunerado_dia"].ToString();
                    obEIndAusentismoxCargo.c_remunerado_persona = drd["c_remunerado_persona"].ToString();
                    obEIndAusentismoxCargo.d_no_remunerado_persona = drd["d_no_remunerado_persona"].ToString();
                    obEIndAusentismoxCargo.e_dotacion = drd["e_dotacion"].ToString();
                    obEIndAusentismoxCargo.f_porc_remunerado = drd["f_porc_remunerado"].ToString();
                    obEIndAusentismoxCargo.g_porc_no_remunerado = drd["g_porc_no_remunerado"].ToString();
                    lEIndAusentismoxCargo.Add(obEIndAusentismoxCargo);
                }
                drd.Close();
            }

            return (lEIndAusentismoxCargo);
        }
    }
}