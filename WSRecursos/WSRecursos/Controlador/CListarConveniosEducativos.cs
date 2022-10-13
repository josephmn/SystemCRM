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
    public class CListarConveniosEducativos
    {
        public List<EListarConveniosEducativos> ListarConveniosEducativos(SqlConnection con, Int32 post, Int32 id)
        {
            List<EListarConveniosEducativos> lEListarConveniosEducativos = null;
            SqlCommand cmd = new SqlCommand("ASP_LISTAR_CONVENIOS_EDUCATIVOS", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@post", SqlDbType.Int).Value = post;
            cmd.Parameters.AddWithValue("@id", SqlDbType.Int).Value = id;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEListarConveniosEducativos = new List<EListarConveniosEducativos>();

                EListarConveniosEducativos obEListarConveniosEducativos = null;
                while (drd.Read())
                {
                    obEListarConveniosEducativos = new EListarConveniosEducativos();
                    obEListarConveniosEducativos.i_id = Convert.ToInt32(drd["i_id"].ToString());
                    obEListarConveniosEducativos.v_nombre = drd["v_nombre"].ToString();
                    obEListarConveniosEducativos.v_tarjeta = drd["v_tarjeta"].ToString();
                    obEListarConveniosEducativos.v_ventana = drd["v_ventana"].ToString();
                    obEListarConveniosEducativos.i_estado = Convert.ToInt32(drd["i_estado"].ToString());
                    obEListarConveniosEducativos.v_estado = drd["v_estado"].ToString();
                    obEListarConveniosEducativos.v_color_estado = drd["v_color_estado"].ToString();
                    obEListarConveniosEducativos.d_finicio = drd["d_finicio"].ToString();
                    obEListarConveniosEducativos.d_ffin = drd["d_ffin"].ToString();
                    obEListarConveniosEducativos.i_condicion = Convert.ToInt32(drd["i_condicion"].ToString());
                    obEListarConveniosEducativos.v_condicion = drd["v_condicion"].ToString();
                    obEListarConveniosEducativos.v_class = drd["v_class"].ToString();
                    obEListarConveniosEducativos.v_href = drd["v_href"].ToString();
                    obEListarConveniosEducativos.v_target = drd["v_target"].ToString();
                    obEListarConveniosEducativos.v_none_imagen = drd["v_none_imagen"].ToString();
                    obEListarConveniosEducativos.v_none_pdf = drd["v_none_pdf"].ToString();
                    obEListarConveniosEducativos.v_icon = drd["v_icon"].ToString();
                    obEListarConveniosEducativos.v_color_icon = drd["v_color_icon"].ToString();
                    lEListarConveniosEducativos.Add(obEListarConveniosEducativos);
                }
                drd.Close();
            }

            return (lEListarConveniosEducativos);
        }
    }
}