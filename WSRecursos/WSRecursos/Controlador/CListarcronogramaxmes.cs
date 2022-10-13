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
    public class CListarcronogramaxmes
    {
        public List<EListarcronogramaxmes> Listar_Listarcronogramaxmes(SqlConnection con, Int32 mes, Int32 anhio)
        {
            List<EListarcronogramaxmes> lEListarcronogramaxmes = null;
            SqlCommand cmd = new SqlCommand("ASP_LISTAR_CRONOGRAMAXMES", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@mes", SqlDbType.Int).Value = mes;
            cmd.Parameters.AddWithValue("@anhio", SqlDbType.Int).Value = anhio;
                
            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEListarcronogramaxmes = new List<EListarcronogramaxmes>();

                EListarcronogramaxmes obEListarcronogramaxmes = null;
                while (drd.Read())
                {
                    obEListarcronogramaxmes = new EListarcronogramaxmes();
                    obEListarcronogramaxmes.i_id = drd["i_id"].ToString();
                    obEListarcronogramaxmes.v_dni = drd["v_dni"].ToString();
                    obEListarcronogramaxmes.v_nombres = drd["v_nombres"].ToString();
                    obEListarcronogramaxmes.v_nommes = drd["v_nommes"].ToString();
                    obEListarcronogramaxmes.v_dias = drd["v_dias"].ToString();
                    obEListarcronogramaxmes.d_finicio = drd["d_finicio"].ToString();
                    obEListarcronogramaxmes.d_ffin = drd["d_ffin"].ToString();
                    obEListarcronogramaxmes.v_total = drd["v_total"].ToString();
                    obEListarcronogramaxmes.i_tipo = drd["i_tipo"].ToString();
                    obEListarcronogramaxmes.v_tipo = drd["v_tipo"].ToString();
                    obEListarcronogramaxmes.v_color_tipo = drd["v_color_tipo"].ToString();
                    obEListarcronogramaxmes.v_estado = drd["v_estado"].ToString();
                    obEListarcronogramaxmes.i_anhio = drd["i_anhio"].ToString();
                    obEListarcronogramaxmes.v_mes = drd["v_mes"].ToString();
                    obEListarcronogramaxmes.v_color = drd["v_color"].ToString();
                    obEListarcronogramaxmes.v_control = drd["v_control"].ToString();
                    lEListarcronogramaxmes.Add(obEListarcronogramaxmes);
                }
                drd.Close();
            }

            return (lEListarcronogramaxmes);
        }
    }
}