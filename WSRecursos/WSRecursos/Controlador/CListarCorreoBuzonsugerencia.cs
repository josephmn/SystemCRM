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
    public class CListarCorreoBuzonsugerencia
    {
        public List<EListarCorreoBuzonsugerencia> ListarCorreoBuzonsugerencia(SqlConnection con, Int32 post, String dni)
        {
            List<EListarCorreoBuzonsugerencia> lEListarCorreoBuzonsugerencia = null;
            SqlCommand cmd = new SqlCommand("ASP_LISTAR_BUZON_SUGERENCIA", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@post", SqlDbType.Int).Value = post;
            cmd.Parameters.AddWithValue("@dni", SqlDbType.VarChar).Value = dni;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEListarCorreoBuzonsugerencia = new List<EListarCorreoBuzonsugerencia>();

                EListarCorreoBuzonsugerencia obEListarCorreoBuzonsugerencia = null;
                while (drd.Read())
                {
                    obEListarCorreoBuzonsugerencia = new EListarCorreoBuzonsugerencia();
                    obEListarCorreoBuzonsugerencia.i_id = drd["i_id"].ToString();
                    obEListarCorreoBuzonsugerencia.v_ticket = drd["v_ticket"].ToString();
                    obEListarCorreoBuzonsugerencia.v_nombre = drd["v_nombre"].ToString();
                    obEListarCorreoBuzonsugerencia.v_para = drd["v_para"].ToString();
                    obEListarCorreoBuzonsugerencia.v_copia = drd["v_copia"].ToString();
                    obEListarCorreoBuzonsugerencia.i_asunto = Convert.ToInt32(drd["i_asunto"].ToString());
                    obEListarCorreoBuzonsugerencia.v_asunto = drd["v_asunto"].ToString();
                    obEListarCorreoBuzonsugerencia.v_mensaje = drd["v_mensaje"].ToString();
                    obEListarCorreoBuzonsugerencia.v_estado = drd["v_estado"].ToString();
                    obEListarCorreoBuzonsugerencia.v_color = drd["v_color"].ToString();
                    obEListarCorreoBuzonsugerencia.d_fecha = drd["d_fecha"].ToString();
                    lEListarCorreoBuzonsugerencia.Add(obEListarCorreoBuzonsugerencia);
                }
                drd.Close();
            }

            return (lEListarCorreoBuzonsugerencia);
        }
    }
}