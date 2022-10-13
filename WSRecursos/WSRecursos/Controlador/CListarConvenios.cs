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
    public class CListarConvenios
    {
        public List<EListarConvenios> ListarConvenios(SqlConnection con, Int32 post, Int32 id)
        {
            List<EListarConvenios> lEListarConvenios = null;
            SqlCommand cmd = new SqlCommand("ASP_LISTAR_CONVENIOS", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@post", SqlDbType.Int).Value = post;
            cmd.Parameters.AddWithValue("@id", SqlDbType.Int).Value = id;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEListarConvenios = new List<EListarConvenios>();

                EListarConvenios obEListarConvenios = null;
                while (drd.Read())
                {
                    obEListarConvenios = new EListarConvenios();
                    obEListarConvenios.i_id = Convert.ToInt32(drd["i_id"].ToString());
                    obEListarConvenios.v_nombre = drd["v_nombre"].ToString();
                    obEListarConvenios.v_tarjeta = drd["v_tarjeta"].ToString();
                    obEListarConvenios.v_ventana = drd["v_ventana"].ToString();
                    obEListarConvenios.i_estado = Convert.ToInt32(drd["i_estado"].ToString());
                    obEListarConvenios.v_estado = drd["v_estado"].ToString();
                    obEListarConvenios.v_color_estado = drd["v_color_estado"].ToString();
                    obEListarConvenios.d_finicio = drd["d_finicio"].ToString();
                    obEListarConvenios.d_ffin = drd["d_ffin"].ToString();
                    obEListarConvenios.i_condicion = Convert.ToInt32(drd["i_condicion"].ToString());
                    obEListarConvenios.v_condicion = drd["v_condicion"].ToString();
                    obEListarConvenios.v_none_texto = drd["v_none_texto"].ToString();
                    obEListarConvenios.v_class = drd["v_class"].ToString();
                    obEListarConvenios.v_href = drd["v_href"].ToString();
                    obEListarConvenios.v_target = drd["v_target"].ToString();
                    obEListarConvenios.v_none_imagen = drd["v_none_imagen"].ToString();
                    obEListarConvenios.v_none_pdf = drd["v_none_pdf"].ToString();
                    obEListarConvenios.v_icon = drd["v_icon"].ToString();
                    obEListarConvenios.v_color_icon = drd["v_color_icon"].ToString();
                    lEListarConvenios.Add(obEListarConvenios);
                }
                drd.Close();
            }

            return (lEListarConvenios);
        }
    }
}